# Stage 5. Creating Technical Documentation

## Your Role

Act as a **Lead Technical Writer**.
A Technical Writer is a specialist who creates and maintains technical documentation for products, systems, and processes.
They translate complex technical information into a clear and accessible format for various audiences: users, developers, administrators.

## Input Parameters (User Input)

{YYYY}/{MM}/{ISSUE_FOLDER} - year/month/folder name. If the parameter is not provided, it should be requested from the user.

## What Needs to Be Done

Carefully study:
- Project information in [`AGENTS.md`](/AGENTS.md)
- New business requirements in [`Spec.md`](../Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Spec.md)
- Implementation plan in [StageX_TaskForDev.md](/Doc/Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Stages/StageX_TaskForDev.md)
- Testing plan in [StageX_TaskForTest.md](/Doc/Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Stages/StageX_TaskForTest.md)

1. Create a new file `/backend/src/{MODULE_FOLDER}/Readme.md` with detailed technical documentation for the implemented module.
   If the file already exists, it should be updated.

2. Ask clarifying questions as needed.

### Determining {MODULE_FOLDER}

- Extract the module name from the context in [Task.md](/Doc/Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Task.md). Look for module mentions in file paths (for example, for "backend/src/Ticket/Domain/Entity/Ticket.php" - it's "Ticket").
- If multiple modules are affected, create `Readme.md` files for each.
- If changes affect Core (project-wide code), create or update [`Readme.md`](/Core/Readme.md).

**IMPORTANT**
You must read all created and modified files in the module, as there is a possibility that the implementation differs from [StageX_TaskForDev.md](../Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Stages/StageX_TaskForDev.md) and [StageX_TaskForTest.md](../Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Stages/StageX_TaskForTest.md)
The Readme.md should describe the actual implementation.

The description should be detailed, but without unnecessary technical details.

### Readme.md Structure

Use the following template to create documentation.
All sections should be in Russian, as specified in the project rules.
All additional files should be created in `/backend/src/{MODULE_FOLDER}/Domain/Doc`, for example diagrams or external API descriptions.

#### 1. Module Architecture and Structure Description

- Describe the overall module architecture in accordance with [Clean Architecture](/.ai/rules/Architecture.md).
- Include diagrams (e.g., PlantUML or Mermaid) to visualize layers (Domain, Application, Infrastructure, Presentation).
- List key components and their roles.

#### 2. Domain Description ([Domain](/.ai/rules/Architecture.md#domain))

- Describe entities (Entity), value objects (ValueObject), interfaces, and events.
- Provide examples of using Domain interfaces by other modules.

#### 3. Business Logic Implementation Description ([Application](/.ai/rules/Architecture.md#application))

- Describe UseCase, Command, Query, Service and their interaction.
- Specify business rule validation at the Application level (business rules, not structural ones).
- Describe how UseCase coordinates work (for example, 'UseCase calls Query to get data, then Command to save').

#### 4. API Interface Documentation ([Presentation](/.ai/rules/Architecture.md#presentation))

- List controllers, middleware, and routes.
- Provide examples of endpoints with parameters and responses (use JSON examples).
- Describe input data validation.

#### 5. Integration with External Systems ([Infrastructure](/.ai/rules/Architecture.md#infrastructure))

- Describe Repository, Adapter and their implementation.
- Specify how the module interacts with external APIs (for example, Freshdesk).

#### 6. Dependencies

- Describe environment variable configuration in [.env.example](../../backend/.env.example).
- Specify dependencies on other modules (for example, 'Ticket module depends on Core for common exceptions').
- Specify dependencies on external libraries.

#### 8. Module Testing

Specify the location of tests: `backend/tests/Suite/{ModuleName}/` (for example, Unit tests in `backend/tests/Suite/{ModuleName}/Domain/`, Functional in `backend/tests/Suite/{ModuleName}/Application/`).

Detailed description of test methods is not required.
It is redundant to add a description of running tests.

#### 9. Usage Scenarios

- Describe module usage scenarios in the application from the file [Spec.md](../Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Spec.md).

## Stage Completion Criteria

- A `Readme.md` file is created for each implemented module according to the template
- Documentation is written in Russian and follows the structure described in the template
- All template sections are filled with current information about the module
- If external APIs are present, documentation files are created in `/backend/src/{MODULE_FOLDER}/Domain/Doc`
- Module dependencies on other modules and external libraries are specified
- Module usage scenarios from the file [Spec.md](../Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Spec.md) are described

## User Review of Tests

If review passed → proceed to commit. If not → fix the description and repeat checks.

## Committing Changes to Git

The comment should be in Russian
