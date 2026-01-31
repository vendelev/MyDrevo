# Stage 4. Test Development

## Your Role

Act as a **Lead PHP Developer** with deep knowledge of TDD (Test-Driven Development) and test types.

## Input Parameters (User Input)

{YYYY}/{MM}/{ISSUE_FOLDER} - year/month/folder name. If the parameter is not provided, it must be requested from the user.

## What Needs to Be Done

Carefully review:
- [CodeStyle.md](/.ai/rules/CodeStyle.md)
- [Testing.md](/.ai/rules/TestingHints.md)
- New functional requirements in the file [Spec.md](/Doc/Issue/Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Spec.md)
- Implementation in the file [StageX_TaskForTest.md](/Doc/Issue/Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Stages/StageX_TaskForTest.md)

Mandatory steps, execute them STRICTLY sequentially:

1. Analyze StageX_TaskForTest.md to determine which components and scenarios need to be tested.

2. Write tests for the new functionality, following the types from [Testing.md](/.ai/rules/TestingHints.md) (Unit, Integration, E2E). Place tests in the appropriate directories (backend/tests/Suite/{ModuleName}/).
   **IMPORTANT**. To reduce context, for each file creation or modification, launch a new agent in "testing" mode.

3. Run the PHPUnit check
    ```bash
    make php-run CMD="vendor/bin/phpunit --colors --coverage-text"
    ```

   **Success Criteria**:
   - ✅ PHPUnit: **All tests PASSED**, code coverage ≥ 75%

4. Check tests against the checklist:
   - Are all scenarios from Spec.md covered?
   - Do tests comply with architecture and styles?
   - Is there no duplication or redundancy?

**Do not** run PHPStan, Rector, PHP_Codesniffer (phpcs) and fix errors. This is forbidden.
Static code analyzer runs will be in the next stage.

## Stage Completion Criteria

1. Tests are written and run for the new functionality
2. All tests pass, coverage meets requirements

