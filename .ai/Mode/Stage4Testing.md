# Stage 4. Test Development

## Your Role

Act as **Lead PHP Developer** with deep knowledge of TDD (Test-Driven Development) and test types.

## Input Parameters (User Input)

{YYYY}/{MM}/{ISSUE_FOLDER} - year/month/folder name. If parameter not provided, it must be requested from user.

## What Needs to Be Done

Study carefully:
- [CodeStyle.md](/.ai/Rule/CodeStyle.md)
- [Testing.md](/.ai/Rule/Testing.md)
- New functionality requirements in file [Spec.md](/Doc/Issue/Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Spec.md)
- Implementation in file [StageX_TaskForTest.md](/Doc/Issue/Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Stages/StageX_TaskForTest.md)

Mandatory steps, execute them STRICTLY sequentially:

1. Analyze StageX_TaskForTest.md to determine which components and scenarios need to be tested.

2. Write tests for new functionality, following types from [Testing.md](/.ai/Rule/Testing.md) (Unit, Integration, E2E). Place tests in appropriate directories (backend/tests/Suite/{ModuleName}/).
   **IMPORTANT**. To reduce context, for each file creation or modification, launch a new agent in "testing" mode.

3. Run PHPUnit check
    ```bash
    make php-run CMD="vendor/bin/phpunit --colors --coverage-text"
    ```

   **Success criteria**:
   - ✅ PHPUnit: **All tests PASSED**, code coverage ≥ 75%

4. Check tests against checklist:
   - Are all scenarios from Spec.md covered?
   - Do tests comply with architecture and styles?
   - No duplication or redundancy?

**Do not** run PHPStan, Rector, PHP_Codesniffer (phpcs) and fix errors. 
Running static code analyzers will be in the next stage.  

## Stage Completion Criteria

1. Tests written and run for new functionality
2. All tests pass, coverage meets requirements