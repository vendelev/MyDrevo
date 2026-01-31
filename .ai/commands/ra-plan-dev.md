# Create a technical plan for code development.

## Input Data

$ARGUMENTS

## Workflow

### Step 1. Creating the code development plan

Call the Task tool (switch_mode) to create the code development plan:

- `subagent_type`: `create-plan-dev`
- `prompt`: "Based on business requirements and the summary plan for stage {X}
  for task @/Doc/Issue/{YYYY}/{MM}/{ISSUE_FOLDER}, create a code development plan according to the instructions.
  Return a list of created or modified files for subsequent verification."

Wait for the agent to complete and save the list of files from its response.

### Step 2. Re-checking created files

After the agent completes, call the Task tool (switch_mode) for re-checking:

- `subagent_type`: `create-plan-dev`
- `prompt`: "Re-check the created file {file path} for compliance with your instructions.
  Return a list of remarks."

To reduce context, assign each agent to check only one file.

Wait for the agent to complete and save the list of remarks.

### Step 3. Fixing remarks

If remarks are found, for each file call a separate Task tool (switch_mode):

- `subagent_type`: `create-plan-dev`
- `prompt`: "Make corrections to file {file path} according to remarks: {list of remarks}"

To reduce context, assign each agent to modify only one file.

If there are no remarks — proceed to step 4.

### Step 4. Formatting check

For each created or modified file, call a separate Task tool (switch_mode):

- `subagent_type`: `markdownlint`
- `prompt`: "Check and fix formatting of file: {file_path}"

Call a separate `markdownlint` agent for each file.
