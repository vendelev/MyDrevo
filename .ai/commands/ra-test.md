# Write tests.

## Input Data

$ARGUMENTS

## Workflow Algorithm

### Step 1. Writing Tests

Call Task tool (switch_mode) to write tests:

- `subagent_type`: `testing`
- `prompt`: "Write tests for implementation stage {X} from file
  @/Doc/Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Task.md according to instructions.
  Return a list of created or modified files for subsequent verification."

Wait for the agent to complete and save the list of files from its response.

### Step 2. Re-verification

After the agent completes, call Task tool (switch_mode) for re-verification:

- `subagent_type`: `testing`
- `prompt`: "Re-verify the created file {file path} for compliance with your instructions.
  Return a list of remarks."

To reduce context, assign each agent the task of checking only one file.

Wait for the agent to complete and save the list of remarks.

### Step 3. Fixing Remarks

If remarks are found, call a separate Task tool (switch_mode) for each file:

- `subagent_type`: `testing`
- `prompt`: "Make corrections to file {file path} according to remarks: {list of remarks}"

To reduce context, assign each agent the task of modifying only one file.

### Step 4. Automatic Code and Style Fix

Call Task tool (switch_mode):

- `subagent_type`: `code-auto-fix`
- `prompt`: "Fix code and style"

### Step 5. Type Error Checking

Call Task tool (switch_mode):

- `subagent_type`: `phpstan`
- `prompt`: "Check and fix type errors"

If the agent returns an error message, restart the subtask (no more than 2 times).

### Step 6. Refactoring

Call Task tool (switch_mode):

- `subagent_type`: `rector`
- `prompt`: "Check and fix code"

### Step 7. Code Style Check

Call Task tool (switch_mode):

- `subagent_type`: `phpcs`
- `prompt`: "Check and fix code style"

If the agent returns an error message, restart the subtask (no more than 2 times).

### Step 8. Running Tests

Call Task tool (switch_mode):

- `subagent_type`: `testing`
- `prompt`: "Run PHPUnit tests and check results"

### Step 9. Mark Stage as Completed

In the Task.md file, mark the corresponding implementation stage as completed (✅ Stage completed).
