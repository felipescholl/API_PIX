**Plano Semanal para Implementação das Atualizações**  
*(Baseado nas mudanças identificadas entre os textos A e B)*  

---

### **Semana 1: Aprimoramentos em Seções Existentes**  
**Foco:** Cobrança/Pagamento, Interface do Sistema e Integrações Básicas  

1. **Cobrança e Pagamento**  
   - **Descontos:**  
     - Definir regras de descontos fixos no SISCLAS (exclusão de descontos no SCR).  
     - Documentar fluxo para evitar conflitos entre sistemas.  
   - **Validade de Títulos:**  
     - Adicionar campo `dias_pos_vencimento` na tabela de títulos (valor padrão: 365 dias).  
     - Validar com GFI se o prazo de 365 dias é aplicável a todos os casos.  
   - **Cancelamento e Nova Cobrança:**  
     - Implementar lógica para cancelar títulos vencidos e gerar novos automaticamente (aguardar confirmação do GFI).  

2. **Interface do Sistema**  
   - **Webhook para Notificações:**  
     - Projetar estrutura do webhook (ex.: endpoints, eventos como "pagamento confirmado").  
     - Iniciar integração com Sapiens para sincronização de status.  
   - **Estrutura do TXID:**  
     - Atualizar TXID para incluir `contador diário` e `data de geração` (ex.: `SCR000003725C512P31024T250217`).  
     - Testar compatibilidade com sistemas legados (evitar conflitos com "Bug do Milênio do Boleto").  

3. **Tratamento de Erros Iniciais**  
   - Criar rotina de resincronização de dados com Sapiens para casos de falha na geração instantânea.  

**Entregas da Semana 1:**  
- Documentação técnica atualizada.  
- Protótipo do webhook e nova estrutura de TXID.  
- Campo `dias_pos_vencimento` adicionado ao banco de dados.  

---

### **Semana 2: Aprimoramentos em Cancelamento, Contabilidade e Compliance**  
**Foco:** Automatização de Processos e Conformidade  

1. **Cancelamento e Negociação**  
   - **Cancelamento Automático (Status "CA"):**  
     - Implementar alteração de status para "CA" no Sicredi após expiração.  
     - Disparar notificação automática para SISCLAS/SCR.  
   - **Regeração de Títulos no SCR:**  
     - Desenvolver fluxo para gerar novo título no SCR e manter histórico no banco PIX.  

2. **Questões Contábeis**  
   - **Classificação de Pagamentos:**  
     - Reunião com GFI para definir critérios de classificação no plano de contas.  
   - **Exportação de Dados:**  
     - Garantir que a exportação (CSV/XLS) funcione corretamente nos sistemas emissores.  

3. **Compliance**  
   - Definir regras para tratamento de títulos no final do ano contábil (ex.: arquivamento ou renovação).  

**Entregas da Semana 2:**  
- Fluxo automatizado de cancelamento e regeneração de títulos.  
- Relatório de conformidade com regras contábeis.  
- Integração SCR/SISCLAS validada.  

---

### **Semana 3: Novas Questões e Requisitos Funcionais**  
**Foco:** Novas Funcionalidades e Resolução de Dependências  

1. **Novas Questões**  
   - **Exclusão de Cobranças:**  
     - Garantir que apenas o cancelamento seja permitido (não exclusão física).  
     - Atualizar interfaces para ocultar opção de "excluir".  
   - **Armazenamento de QR Code:**  
     - Decidir se o SVG será gerado localmente ou via API (avaliar necessidade do pacote PHP 8.2).  
     - Definir política de retenção (ex.: 6 meses após pagamento).  

2. **Requisitos Funcionais**  
   - **Parcelamento:**  
     - Implementar lógica para tratar cada parcela como título único (incluir número da parcela no TXID).  
   - **Histórico de Alterações:**  
     - Criar tabela de histórico no SISCLAS (ex.: alterações de valor, vencimento).  

**Entregas da Semana 3:**  
- Política de armazenamento de QR Code definida.  
- Lógica de parcelamento implementada.  
- Tabela de histórico no SISCLAS criada.  

---

### **Semana 4: Testes, Validação e Documentação Final**  
**Foco:** Estabilização e Preparação para Deploy  

1. **Testes de Integração**  
   - Validar webhook, sincronização com Sapiens e geração de TXID.  
   - Testar cenários de cancelamento automático e regeneração de títulos.  

2. **Documentação**  
   - Atualizar manual do usuário com novas funcionalidades (ex.: parcelamento, políticas de cancelamento).  
   - Criar FAQ para dúvidas comuns (ex.: tratamento de erros, estrutura do TXID).  

3. **Resolução de Pendências**  
   - Finalizar decisão sobre pacote PHP para QR Code (alternativa caso não haja compatibilidade).  
   - Ajustar compliance com base em feedback do GFI.  

**Entregas da Semana 4:**  
- Sistema estável e testado.  
- Documentação completa publicada.  
- Treinamento para equipes de suporte.  

---

### **Observações Gerais:**  
- **Priorização:** Sempre validar mudanças com GFI/Sênior antes de implementar.  
- **Comunicação:** Reuniões diárias rápidas para alinhar progresso e bloqueios.  
- **Backup:** Manter versões anteriores do banco de dados durante atualizações críticas.  


---

### Tarefas resumo:

**Aprimoramentos em Cobrança/Pagamento:**
- [ ] Preparar endpoint para SISCLAS onde haverá tratamento diferenciado das cobranças.
- [ ] Implementar regras de descontos fixos no SISCLAS e bloquear descontos no SCR.
- [ ] Adicionar campo dias_pos_vencimento (365 dias para SCR) na tabela de títulos.
- [ ] Desenvolver lógica para cancelar títulos vencidos (após confirmação do GFI).

**Interface e Identificação (TXID):**
- [ ] Redefinir estrutura do TXID com contador diário, data de geração e dados do projeto (ex.: SCR000003725C512P31024T250217xx).

**Cancelamento Automático:**
- [ ] Configurar alteração automática de status para "CA" (cancelado) no Sicredi após expiração.
- [ ] Disparar api reversa para sistema que criou cobrança.

**Novas Funcionalidades:**
- [ ] Verificar compatibilidade quanto ao parcelamento (cada parcela como título único no TXID, ou se varias cobranças podem ter mesmo título).
- [ ] Criar webhook para notificar sistemas externos sobre status de pagamentos.

**QR Code:**
- [ ] Definir política de armazenamento do QR Code (tempo de retenção e formato de geração).
- [ ] Como PHP 5 (usado no SCR) carece de opções de geração de QRCode verificar como será o envio dos mesmos na requisição.

**Exclusão vs. Cancelamento:**
- [ ] Remover opção de exclusão física de cobranças, mantendo apenas cancelamento.

**Testes e Validação:**
- [ ] Testar integração do webhook, sincronização com Sapiens e fluxos de cancelamento.

**GFI:**
- [ ] Validação com GFI e definição de parâmetros (codTpt, numCco, codTns, codCli, codCrt, ...).
- [ ] Homologação da estrutura do TXID.
- [ ] Definir critérios de classificação de pagamentos no plano de contas (com GFI).
- [ ] Estabelecer regras para tratamento de títulos no final do ano contábil (com GFI).

