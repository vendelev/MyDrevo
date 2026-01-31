# Create a technical plan for writing tests.

## Input Data

$ARGUMENTS

## Workflow

### Step 1. Creating the Test Plan

Call the Task tool (switch_mode) to create the test plan:

- `subagent_type`: `create-plan-test`
- `prompt`: "Based on the business requirements and summary plan for stage {X}
  for task @/Doc/Issue/{YYYY}/{MM}/{ISSUE_FOLDER}, create a plan for writing tests according to the instructions.
  Return a list of created or modified files for subsequent verification."

Wait for the agent to complete and save the list of files from its response.

### Step 2. Re-checking the Created Files

After the agent finishes, call the Task tool (switch_mode) for re-checking:

- `subagent_type`: `create-plan-test`
- `prompt`: "Re-check the created file {file path} for compliance with your instructions.
  Return a list of remarks."

To reduce context, give each agent a task to check only one file.

Wait for the agent to complete and save the list of remarks.

### Step 3. Fixing Remarks

If remarks are found, call a separate Task tool (switch_mode) for each file:

- `subagent_type`: `create-plan-test`
- `prompt`: "Make corrections to file {file path} according to the remarks: {list of remarks}"

To reduce context, give each agent a task to modify only one file.

If there are no remarks — proceed to step 4.

### Step 4. Formatting Check

For each created or modified file, call a separate Task tool (switch_mode):

- `subagent_type`: `markdownlint`
- `prompt`: "Check and fix the formatting of the file: {file_path}"

Call a separate `markdownlint` agent for each file.
