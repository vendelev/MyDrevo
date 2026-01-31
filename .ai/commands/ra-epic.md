# Create business requirements description and break down work into stages (epic).

## Input Data

$ARGUMENTS

## Workflow Algorithm

### Step 1. Creating the Epic

Call the Task tool (switch_mode) to describe business requirements:

- `subagent_type`: `create-epic`
- `prompt`: "Epic number: {epic number from tracker}. Business requirements description: {description from $ARGUMENTS}.
  Return a list of created or modified files for subsequent verification"

Wait for the agent to complete and save the list of files from its response.

### Step 2. Verification of Created Files

After the agent completes its work, call the Task tool (switch_mode) for verification:

- `subagent_type`: `create-epic`
- `prompt`: "Verify the created files {list of files} against your instructions.
  Return a list of files and a list of remarks for each file"

Wait for the agent to complete and save the list of remarks.

### Step 3. Fixing Remarks

If remarks are found, call a separate Task tool (switch_mode) for each file:

- `subagent_type`: `create-epic`
- `prompt`: "Make corrections to the file {file path} according to the remarks: {list of remarks}"

To reduce context, give each agent a task to modify only one file.

If there are no remarks — proceed to step 4.

### Step 4. Formatting Check

For each created or modified file, call a separate Task tool (switch_mode):

- `subagent_type`: `markdownlint`
- `prompt`: "Check and fix the formatting of the file: {file_path}"

Call a separate `markdownlint` agent for each file.
