# Create a summary technical plan.

## Input Data

$ARGUMENTS

## Work Algorithm

### Step 1. Creating the summary plan

Call the Task tool (switch_mode) to create the summary plan:

- `subagent_type`: `create-plan-sum`
- `prompt`: "Based on business requirements from the file @/Doc/Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Spec.md
  create a summary plan for code and test development according to the instructions.
  Return a list of created or modified files for subsequent verification."

Wait for the agent to complete and save the list of files from its response.

### Step 2. Re-checking the created files

After the agent finishes, call the Task tool (switch_mode) for re-checking:

- `subagent_type`: `create-plan-sum`
- `prompt`: "Re-check the created files {list of files} for compliance with your instructions.
  Return a list of remarks for each file."

Wait for the agent to complete and save the list of remarks.

### Step 3. Fixing remarks

If remarks are found, for each file call a separate Task tool (switch_mode):

- `subagent_type`: `create-plan-sum`
- `prompt`: "Make corrections to the file {file path} according to the remarks: {list of remarks}"

To reduce context, give each agent a task to modify only one file.
