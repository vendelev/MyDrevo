# Create architectural documentation.

## Input Data

$ARGUMENTS

## Workflow

### Step 1. Creating Architectural Documentation

Call the Task tool (switch_mode) to create architectural documentation:

- `subagent_type`: `arch-doc`
- `prompt`: "Based on business requirements and the development and testing plan
  in the folder @/Doc/Issue/{YYYY}/{MM}/{ISSUE_FOLDER}, create architectural documentation according to the instructions.
  Return a list of created or modified files for subsequent review"

Wait for the agent to complete and save the list of files from its response.

### Step 2. Re-verification of Created Files

After the agent completes, call the Task tool (switch_mode) for re-verification:

- `subagent_type`: `arch-doc`
- `prompt`: "Re-verify the created files {list of files} for compliance with your instructions.
  Return a list of remarks for each file"

Wait for the agent to complete and save the list of remarks.

### Step 3. Fixing Remarks

If remarks are found, for each file call a separate Task tool (switch_mode):

- `subagent_type`: `arch-doc`
- `prompt`: "Make corrections to the file {path to file} according to the remarks: {list of remarks}"

To reduce context, give each agent a task to modify only one file.

If there are no remarks - proceed to step 4.

### Step 4. Formatting Verification

For each created or modified md-file, call a separate Task tool (switch_mode):

- `subagent_type`: `markdownlint`
- `prompt`: "Check and fix the formatting of the file: {path_to_file}"

Call a separate `markdownlint` agent for each file.
