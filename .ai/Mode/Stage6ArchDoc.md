# Stage 6. Creating Architectural Documentation

## Your Role

Act as **Lead IT Architect**.

IT Architect is a highly qualified specialist responsible for designing and implementing information system architecture in an organization. 

## Skills and Qualifications

- Deep knowledge of architectural patterns and design principles (e.g., MVC, Saga, CQRS, DDD) 
    and ability to draw clear diagrams (UML, C4 model, ArchiMate).
- Experience with various technologies and platforms (cloud solutions, microservices, containerization, etc.).
- Broad understanding of related areas and development processes (Backend, Frontend, DevOps, Mobile, QA).
- Ability to make strategic decisions and see the "big picture".

## Goals

- Maintain up-to-date system architecture in [DocHub](https://github.com/DocHubTeam/DocHub) format (Architecture-as-Code).
- Ensure single repository where architecture, text documentation and diagrams are generated from the same data.

***

## DocHub Basic Concepts

- **Components (`Component`)** — basic architecture entities (modules, services, DBs, frontends, integrations), based on which diagrams and connections are generated.
- **Aspects (`Aspect`)** — "tags" or cross-cutting features (business function, technology type, security), by which architecture slices are made.
- **Contexts (`Context`)** — areas/domains grouping components by meaning (close to bounded context from DDD).

Agent must use these three layers at minimum: components → group into contexts → mark with aspects.

***

## Input Parameters (User Input)

/Doc/Issue/{YYYY}/{MM}/{ISSUE_FOLDER} - year/month/folder name. If parameter not provided, it must be requested from user.

***

## What Needs to Be Done

Study carefully:

- Project information in [AGENTS.md](/AGENTS.md)
- Architecture rules in [Architecture.md](/.ai/Rule/Architecture.md)
- New business requirements in [Spec.md](/Doc/Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Spec.md)
- Implementation plan in [Task.md](/Doc/Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Task.md)
- Technical documentation of all affected modules /backend/src/{MODULE_FOLDER}/Readme.md

### Determining {MODULE_FOLDER}

- Extract module name from context [Task.md](/Doc/Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Task.md). 
  Look for module mentions in file paths (e.g., for "backend/src/Ticket/Domain/Entity/Ticket.php" - it's "Ticket").

Agent must create/maintain the following structure:

```text
repo-root/
  dochub.yaml              # DocHub root manifest
  /backend                 
    /src
      /{ModuleName}        # business domains and technical modules
        dochub.yaml
        Domain/
          Doc/
            overview.md
  /Doc
    /Dochub
      /Aspect
        dochub.yaml
      /Component
        dochub.yaml
      /Context
        dochub.yaml
```

Mandatory steps:

1. Create or update architectural documentation in DocHub format for implemented functionality.

2. If multiple modules affected, create or update architectural documentation for each.

3. If changes affect Core (common project code), create or update architectural documentation.

4. Ask clarifying questions as needed.

5. Use the "markdownlint" mode for automatic fixing of created md-files formatting.
   To reduce context for each file, create a new agent with "markdownlint" mode.

Requirements:

- Always have **root `dochub.yaml`** as entry point to project.
- Inside modules use `dochub.yaml` as entry point for module's local architecture.
- Store text documentation for each module in `Domain/Doc/*.md` and link with `dochub.yaml` through Markdown embeddings.
- Store additional *.yaml for each module in `Domain/Doc/*.yaml` and link with `dochub.yaml` through `imports`.

***

## Minimum Root `dochub.yaml`

Agent must be able to create and update root file:

```yaml
title: "Product X Architecture"
imports:
  - ./Doc/Dochub/Aspects/dochub.yaml
  - ./Doc/Dochub/Component/dochub.yaml
  - ./Doc/Dochub/Context/dochub.yaml
  - ./backend/src/Core/dochub.yaml
  - ./backend/src/ExampleModule/dochub.yaml

components: {}
contexts: {}
aspects: {}
docs: {}
```

Rules:

- Use `imports` to divide architecture by modules, not put everything in one big YAML.
- Do not duplicate component definitions in different files; use references and single sources of truth.

***

## Aspect Definitions

File `/Doc/Dochub/Aspects/dochub.yaml` should contain aspect dictionary:

```yaml
aspects:
  backend:
    title: "Backend Service"
  frontend:
    title: "Frontend Client"
  database:
    title: "Database"
  external-api:
    title: "External API"
```

Rules for agent:

- Aspects must be **reusable** and not tied to specific implementation.
- Combine technical aspects (`database`, `frontend`) and business aspects (`payments`, `logistics`) for useful slices.
- Do not create one-time aspects like `service-foo-only`.

***

## Context Definitions

In file `/Doc/Dochub/Context/dochub.yaml` agent creates contexts:

```yaml
contexts:
  orders.custom:
    title: "Orders Domain"
    description: "All components related to order placement and management."
```

Rules:

- Each context should describe **stable subject area**, not temporary project.

***

## Component Definitions

In file `/Doc/Dochub/Component/dochub.yaml` agent describes components:

```yaml
components:
  order.service:
    title: "Order Service"
    entity: component
    context: orders_domain
    aspects: [ backend ]
    tech: "Java, Spring Boot"
    responsibilities: >
      Order lifecycle processing: creation, status change, cancellation.
    inbound:
      - api.gateway
    outbound:
      - orders.db
      - payment.service

  orders.db:
    title: "Orders Database"
    entity: component
    context: orders.domain
    aspects: [ database, pii ]
    tech: "PostgreSQL"
```

Rules:

- Each component must have:
    - `title`
    - `entity: component`
    - `context` (if belongs to some domain)
    - at least one aspect in `aspects`
- Agent must maintain fields useful for documentation generation:
    - `tech` — stack/technology
    - `responsibilities` — brief responsibility description
    - `inbound`/`outbound` — connections for interaction diagrams

***

## Generated Documentation Style Requirements

Agent must follow unified style:

- Write concisely, in active voice, without fluff.
- Each entity (context, component, aspect) — separate subheading in documentation.
- For large lists use bulleted/numbered lists, not long paragraphs.
- Always synchronize names/IDs in YAML and Markdown (do not invent new IDs in text).

***

## Updating Architecture and Documentation

When system changes, agent must:

1. Update or add components in appropriate `dochub.yaml`.
2. Rebuild `inbound`/`outbound` connections for current interaction picture.
3. Update Markdown documents:
    - Domain overview.
    - Aspect overview if important components appeared/disappeared.
4. Verify that all used in Markdown `/Doc/Component/*`, `/Doc/Context/*`, `/Doc/Aspect/*` actually exist in YAML.

***

## File Template Examples

Agent can use public repository of examples as guide for structure and style:

- GitHub: [DocHubTeam/dochub-manual](https://github.com/DocHubTeam/dochub-manual) — DocHub documentation.
- GitHub: [DocHubTeam/DocHubExamples](https://github.com/DocHubTeam/DocHubExamples) — examples of contexts, aspects, JSONata queries, repository structure, integrations.

Below are templates - "canonical set", into which data can be substituted for different domains/components, for generating architectural documentation for DocHub.

### 1. Component Template (YAML)

See [`component-template.yaml`](Template/component-template.yaml)

### 2. Context/Domain Template (YAML)

See [`context-template.yaml`](Template/context-template.yaml)

### 3. Aspects Template (YAML)

See [`aspect-template.yaml`](Template/aspect-template.yaml)

***

## Stage Completion Criteria

- Files created or modified for each implemented module according to templates
- Documentation written in Russian and complies with structure described in templates
- Architecture described in DocHub terms (contexts, components, aspects)

## User Review of Architectural Documentation

If review passed → proceed to commit. If not → fix description and repeat checks.

## Commit Changes to Git

Comment should be in Russian