# Create a specification with functional requirements description.

## Input Data

$ARGUMENTS

## Workflow Algorithm

### Step 1. Create Specification

Call Task tool (switch_mode) to describe functional requirements:

- `subagent_type`: `create-spec`
- `prompt`: "Task number: {task number from tracker}.
  The epic description is located in the file @/Doc/Backlog/{YYYY}/{EPIC_FOLDER}/Summary.md.
  Create a functional requirements description for stage {X} according to the instructions.
  Return the list of created or modified files for subsequent verification"

Wait for the agent to complete and save the list of files from its response.

### Step 2. Re-verify Created Files

After the agent completes, call Task tool (switch_mode) for re-verification:

- `subagent_type`: `create-spec`
- `prompt`: "Re-verify the created files {list of files} for compliance with your instructions.
  Return the list of remarks for each file"

Wait for the agent to complete and save the list of remarks.

### Step 3. Fix Remarks

If remarks are found, call a separate Task tool (switch_mode) for each file:

- `subagent_type`: `create-spec`
- `prompt`: "Make corrections to the file {file path} according to the remarks: {list of remarks}"

To reduce context, assign each agent the task of modifying only one file.

If there are no remarks - proceed to step 4.

### Step 4. Formatting Check

For each created or modified file, call a separate Task tool (switch_mode):

- `subagent_type`: `markdownlint`
- `prompt`: "Check and fix formatting of the file: {file_path}"

Call a separate `markdownlint` agent for each file.
