<?php

namespace App\Services;

use Carbon\Carbon;

/**
 * Recupera dias úteis do Brasil utilizando Carbon
 * 
 * @category Date,Carbon
 * @package  App\Services
 * @license  MIT https://opensource.org/licenses/MIT
 */
class BusinessDayBrazilCarbon
{
    /**
     * Retorna a data do próximo dia útil de acordo com a data atual ou especificada
     * no parâmetro $date.
     *
     * @param \Carbon\Carbon|null $date Data alvo.
     * Observações: Se a data passada neste parâmetro for um dia útil ela é retornada, 
     * caso contrário é retornado a data do próximo dia útil referente a ela. 
     * Se $date for null, é retornado a data de amanhã ou do dia útil mais próximo.
     *
     * @return \Carbon\Carbon
     */
    public static function nextDay(?Carbon $date = null)
    {
        // se não for definido $date
        if ($date === null) {
            $date = Carbon::now(); // define a data atual
            $date = $date->addWeekday(); // e a modifica para o próximo dia da semana
        } else {
            // caso $date não for um dia útil
            if (!self::isBusinessDay($date)) {
                $date = $date->copy()->addWeekday(); // a define para o próximo dia da semana
                $date = self::nextDay($date); // e re-executa a função
            }
        }

        return $date;
    }

    /**
     * Verifica se hoje ou a data especificada é dia útil.
     *
     * @param \Carbon\Carbon|null $date Pode ser passado uma data específica para verificar se é um dia útil.
     *
     * @return boolean
     */
    public static function isBusinessDay(?Carbon $date = null)
    {
        if ($date === null) {
            $date = Carbon::now();
        }

        // Verifica se não é final de semana (6=sábado, 7=domingo)
        if (!$date->isWeekend()) {
            // Verifica se não é feriado
            if (!self::isHoliday($date)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Verifica se a data é um feriado
     * 
     * @param \Carbon\Carbon $date Data a ser verificada
     * 
     * @return boolean
     */
    public static function isHoliday(Carbon $date)
    {
        $holidays = self::holidays($date->year);
        
        foreach ($holidays as $holiday) {
            if ($date->isSameDay($holiday)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Recupera feriados do Brasil
     *
     * @param integer|null $year Caso não seja especificado é retornado datas referente ao ano atual.
     *
     * @return array Array de objetos Carbon representando os feriados
     */
    public static function holidays(?int $year = null)
    {
        $year = $year ?: Carbon::now()->year;
        
        // Calcula a data da Páscoa
        $easterDate = Carbon::createFromTimestamp(easter_date($year));
        
        $holidays = [
            // Feriados fixos
            Carbon::create($year, 1, 1), // Confraternização Universal - Lei nº 662, de 06/04/49
            Carbon::create($year, 4, 21), // Tiradentes - Lei nº 662, de 06/04/49
            Carbon::create($year, 5, 1), // Dia do Trabalhador - Lei nº 662, de 06/04/49
            Carbon::create($year, 9, 7), // Dia da Independência - Lei nº 662, de 06/04/49
            Carbon::create($year, 10, 12), // N. S. Aparecida - Lei nº 6802, de 30/06/80
            Carbon::create($year, 11, 2), // Todos os santos - Lei nº 662, de 06/04/49
            Carbon::create($year, 11, 15), // Proclamação da republica - Lei nº 662, de 06/04/49
            Carbon::create($year, 12, 25), // Natal - Lei nº 662, de 06/04/49
            
            // Feriados móveis baseados na Páscoa
            $easterDate->copy()->subDays(48), // Segunda-feira carnaval
            $easterDate->copy()->subDays(47), // Terça-feira carnaval 
            $easterDate->copy()->subDays(2), // Sexta-feira Santa
            $easterDate->copy(), // Páscoa
            $easterDate->copy()->addDays(60), // Corpus Christi
        ];
        
        return $holidays;
    }
    
    /**
     * Ajusta uma data de vencimento para o próximo dia útil caso caia em um feriado ou final de semana
     *
     * @param \Carbon\Carbon $date Data de vencimento
     * 
     * @return \Carbon\Carbon Data ajustada para o próximo dia útil se necessário
     */
    public static function adjustDueDate(Carbon $date)
    {
        if (self::isBusinessDay($date)) {
            return $date;
        }
        
        return self::nextDay($date);
    }
    
    /**
     * Calcula o número de dias úteis entre duas datas
     *
     * @param \Carbon\Carbon $startDate Data inicial
     * @param \Carbon\Carbon $endDate Data final
     * 
     * @return int Número de dias úteis
     */
    public static function businessDaysBetween(Carbon $startDate, Carbon $endDate)
    {
        $days = 0;
        $current = $startDate->copy();
        
        while ($current->lte($endDate)) {
            if (self::isBusinessDay($current)) {
                $days++;
            }
            $current->addDay();
        }
        
        return $days;
    }
}