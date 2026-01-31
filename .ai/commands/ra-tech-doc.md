# Create technical documentation.

## Input data

$ARGUMENTS

## Workflow

### Step 1. Creating technical documentation

Call Task tool (switch_mode) to create technical documentation:

- `subagent_type`: `tech-doc`
- `prompt`: "Based on business requirements and development plan for code and tests
  in the folder @/Doc/Issue/{YYYY}/{MM}/{ISSUE_FOLDER} create technical documentation according to instructions.
  Return a list of created or modified files for subsequent verification."

Wait for the agent to complete and save the list of files from its response.

### Step 2. Re-verification of created files

After the agent completes, call Task tool (switch_mode) for re-verification:

- `subagent_type`: `tech-doc`
- `prompt`: "Re-verify the created files {list of files} for compliance with your instructions.
  Return a list of remarks for each file."

Wait for the agent to complete and save the list of remarks.

### Step 3. Fixing remarks

If remarks are found, for each file call a separate Task tool (switch_mode):

- `subagent_type`: `tech-doc`
- `prompt`: "Make corrections to the file {file path} according to remarks: {list of remarks}"

To reduce context, assign each agent the task of modifying only one file.

If there are no remarks — proceed to step 4.

### Step 4. Formatting verification

For each created or modified file, call a separate Task tool (switch_mode):

- `subagent_type`: `markdownlint`
- `prompt`: "Check and fix formatting of the file: {file_path}"

Call a separate `markdownlint` agent for each file.
