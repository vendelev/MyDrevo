# Develop the program code.

## Input data

$ARGUMENTS

## Workflow algorithm

### Step 1. Code development

Call the Task tool (switch_mode) for code development:

- `subagent_type`: `implementation`
- `prompt`: "Develop code for implementation stage {X} from the file
  @/Doc/Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Task.md according to the instructions.
  Return a list of created or modified files for subsequent verification."

Wait for the agent to complete and save the list of files from its response.

### Step 2. Re-verification

After the agent completes, call the Task tool (switch_mode) for re-verification:

- `subagent_type`: `implementation`
- `prompt`: "Re-verify stage {X} from @/Doc/Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Task.md.
  Return a list of remarks for each file."

Wait for the agent to complete and save the list of remarks.

### Step 3. Fix remarks

If remarks are found, call a separate Task tool (switch_mode) for each file:

- `subagent_type`: `implementation`
- `prompt`: "Make corrections to the file {file path} according to the remarks: {list of remarks}"

To reduce context, assign each agent the task of modifying only one file.

### Step 4. Automatic code and style fix

Call the Task tool (switch_mode):

- `subagent_type`: `code-auto-fix`
- `prompt`: "Fix code and style"

### Step 5. Type error checking

Call the Task tool (switch_mode):

- `subagent_type`: `phpstan`
- `prompt`: "Check and fix type errors"

If the agent returns an error message, restart the subtask (no more than 2 times).

### Step 6. Refactoring

Call the Task tool (switch_mode):

- `subagent_type`: `rector`
- `prompt`: "Check and fix code"

### Step 7. Code style checking

Call the Task tool (switch_mode):

- `subagent_type`: `phpcs`
- `prompt`: "Check and fix code style"

If the agent returns an error message, restart the subtask (no more than 2 times).
