# Stage 5. Creating Technical Documentation

## Your Role

Act as **Lead Technical Writer**.
Technical Writer is a specialist who creates and maintains technical documentation for products, systems and processes.
They translate complex technical information into understandable and accessible format for various audiences: users, developers, administrators.

## Input Parameters (User Input)

{YYYY}/{MM}/{ISSUE_FOLDER} - year/month/folder name. If parameter not provided, it must be requested from user.

## What Needs to Be Done

Study carefully:
- Project information in [`AGENTS.md`](/AGENTS.md)
- New business requirements in [`Spec.md`](../Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Spec.md)
- Implementation plan in [StageX_TaskForDev.md](/Doc/Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Stages/StageX_TaskForDev.md)
- Testing plan in [StageX_TaskForTest.md](/Doc/Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Stages/StageX_TaskForTest.md)

Create new file `/backend/src/{MODULE_FOLDER}/Readme.md` with detailed technical documentation for implemented module.
If file already exists, it must be updated.

### Determining {MODULE_FOLDER}

- Extract module name from context [Task.md](/Doc/Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Task.md). Look for module mentions in file paths (e.g., for "backend/src/Ticket/Domain/Entity/Ticket.php" - it's "Ticket").
- If multiple modules affected, create `Readme.md` files for each.
- If changes affect Core (common project code), create or update [`Readme.md`](/Core/Readme.md).

**IMPORTANT**
All created and modified files in module must be read, as there is possibility that implementation differs from [StageX_TaskForDev.md](../Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Stages/StageX_TaskForDev.md) and [StageX_TaskForTest.md](../Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Stages/StageX_TaskForTest.md)
Readme.md should describe actual implementation. 

Description should be detailed but without excessive technical details.

### Readme.md Structure

Use the following template to create documentation. 
All sections should be in Russian, as specified in project rules.
All additional files should be created in `/backend/src/{MODULE_FOLDER}/Domain/Doc`, for example diagrams or external API descriptions.

#### 1. Module Architecture and Structure Description

- Describe general module architecture in accordance with [Clean Architecture](/.ai/Rule/Architecture.md).
- Include diagrams (e.g., PlantUML or Mermaid) to visualize layers (Domain, Application, Infrastructure, Presentation).
- List key components and their roles.

#### 2. Domain Description ([Domain](/.ai/Rule/Architecture.md#domain))

- Describe entities (Entity), value objects (ValueObject), interfaces and events.
- Provide examples of Domain interface usage by other modules.

#### 3. Business Logic Implementation Description ([Application](/.ai/Rule/Architecture.md#application))

- Describe UseCase, Command, Query, Service and their interaction.
- Specify business rule validation at Application level (business rules, not structural).
- Describe how UseCase coordinates work (e.g., 'UseCase calls Query to get data, then Command to save').

#### 4. API Interface Documentation ([Presentation](/.ai/Rule/Architecture.md#presentation))

- List controllers, middleware and routes.
- Provide endpoint examples with parameters and responses (use JSON examples).
- Describe input data validation.

#### 5. External System Integration ([Infrastructure](/.ai/Rule/Architecture.md#infrastructure))

- Describe Repository, Adapter and their implementation.
- Specify how module interacts with external APIs (e.g., Freshdesk).

#### 6. Dependencies

- Describe environment variable setup in [.env.example](../../backend/.env.example). 
- Specify dependencies on other modules (e.g., 'Ticket module depends on Core for common exceptions').
- Specify dependencies on external libraries.

#### 8. Module Testing

Specify test location: `backend/tests/Suite/{ModuleName}/` (e.g., Unit tests in `backend/tests/Suite/{ModuleName}/Domain/`, Functional in `backend/tests/Suite/{ModuleName}/Application/`).

No need to describe test methods in detail.
Adding test run description is excessive.

#### 9. Use Cases

- Describe module use cases in application from file [Spec.md](../Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Spec.md).

## Stage Completion Criteria

- `Readme.md` file created for each implemented module according to template
- Documentation written in Russian and complies with structure described in template
- All template sections filled with actual module information
- If external APIs present, documentation files created in `/backend/src/{MODULE_FOLDER}/Domain/Doc`
- Module dependencies on other modules and external libraries specified
- Module use cases from file [Spec.md](../Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Spec.md) described
- File formatted according to https://github.com/DavidAnson/markdownlint/blob/main/doc/Rules.md rules
  Check command: `npx markdownlint-cli2 /Doc/Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Task.md`

## User Review of Tests

If review passed → proceed to commit. If not → fix description and repeat checks.

## Commit Changes to Git

Comment should be in Russian
