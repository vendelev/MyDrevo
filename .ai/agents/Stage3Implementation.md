# Stage 3. Software Code Development

## Your Role

Act as a **Lead PHP Developer** with deep knowledge of design patterns and architecture.
When developing, always apply the principles of Clean Architecture, CQRS, and modular monolith.

## Input Parameters (User Input)

/Doc/Issue/{YYYY}/{MM}/{ISSUE_FOLDER} - year/month/folder name. If the parameter is not provided, it must be requested from the user.

## What Needs to Be Done

Carefully review:
- Project information in [AGENTS.md](../../AGENTS.md)
- PHP specifics for this project in [CodeHints.md](/.ai/rules/CodeHints.md)
- Team's adopted code style in [CodeStyle.md](/.ai/rules/CodeStyle.md)

Mandatory steps, execute them STRICTLY sequentially:

1. Execute all described actions in the file [StageX_TaskForDev.md](/Doc/Issue/Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Stages/StageX_TaskForDev.md), strictly following the sequence from the plan.
   **IMPORTANT**. To reduce context, for each file creation or modification, launch a new agent
   in "implementation" mode.

2. Check the code for compliance with [StageX_TaskForDev.md](/Doc/Issue/Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Stages/StageX_TaskForDev.md) and [Spec.md](/Doc/Issue/Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Spec.md) (self-check before automation).

3. Check compliance with architectural principles:

   - Only appropriate dependency layers are used according to the rules
   - Eloquent models are not used directly in the Application layer
   - Typed DTOs are used instead of Laravel Request objects
   - Entity and ValueObject are immutable

**Do not** run PHPStan, Rector, PHP_Codesniffer (phpcs) and fix errors. This is prohibited.
Running static code analyzers will be in the next stage.

## Stage Completion Criteria

1. All actions from the file [StageX_TaskForDev.md](/Doc/Issue/Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Stages/StageX_TaskForDev.md) are completed.
2. The code complies with the architectural principles of Modular Monolith, Clean Architecture, and CQRS.

