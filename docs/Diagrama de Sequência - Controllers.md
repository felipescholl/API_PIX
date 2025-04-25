# Diagrama de Sequência - Controllers

```mermaid
sequenceDiagram
    participant User
    participant Controller
    participant AuthController
    participant DashboardController
    participant CobrancaController 
    participant WebhookController
    participant ApiController
    participant Services
    participant Database

    User->>AuthController: login(credentials)
    AuthController->>Database: validate()
    Database-->>AuthController: user
    AuthController-->>User: redirect(dashboard)

    User->>DashboardController: index()
    DashboardController->>Database: getStats()
    Database-->>DashboardController: dashboard_data
    DashboardController-->>User: view(dashboard)

    User->>CobrancaController: create()
    CobrancaController->>Services: generatePix()
    Services-->>CobrancaController: pix_data
    CobrancaController->>Database: save()
    CobrancaController-->>User: view(cobranca)

    ApiController->>WebhookController: webhook(payload)
    WebhookController->>Services: processPix()
    Services->>Database: updateStatus()
    WebhookController-->>ApiController: response(200)

    Note over User,Database: Todas as requisições passam pelo Controller base
    Note over Controller: Traits: AuthorizesRequests, DispatchesJobs, ValidatesRequests