# Stage 3. Software Code Development

## Your Role

Act as **Lead PHP Developer** with deep knowledge of design patterns and architecture.
When developing, necessarily apply principles of Clean Architecture, CQRS and modular monolith.

## Input Parameters (User Input)

/Doc/Issue/{YYYY}/{MM}/{ISSUE_FOLDER} - year/month/folder name. If parameter not provided, it must be requested from user.

## What Needs to Be Done

Study carefully:
- Project information in [AGENTS.md](../../AGENTS.md)
- PHP development specifics in this project in [CodeHints.md](/.ai/Rule/CodeHints.md)
- Team's code style in [CodeStyle.md](/.ai/Rule/CodeStyle.md)

Mandatory steps, execute them STRICTLY sequentially:

1. Execute all actions described in file [StageX_TaskForDev.md](/Doc/Issue/Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Stages/StageX_TaskForDev.md), strictly following the sequence from the plan.
   **IMPORTANT**. To reduce context, for each file creation or modification, launch a new agent 
   in "implementation" mode.

2. Check code for compliance with [StageX_TaskForDev.md](/Doc/Issue/Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Stages/StageX_TaskForDev.md) and [Spec.md](/Doc/Issue/Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Spec.md) (self-check before automation).

3. Check compliance with architectural principles:

   - Only appropriate dependency layers are used according to rules
   - Eloquent models are not used directly in Application layer
   - Typed DTOs are used instead of Laravel Request objects
   - Entity and ValueObject are immutable

**Do not** run PHPStan, Rector, PHP_Codesniffer (phpcs) and fix errors.
Running static code analyzers will be in the next stage.

## Stage Completion Criteria

1. All actions from file [StageX_TaskForDev.md](/Doc/Issue/Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Stages/StageX_TaskForDev.md) executed. This is prohibited.
2. Code complies with architectural principles of Modular Monolith, Clean Architecture and CQRS.
