<?php

namespace app\modules\teamhelper\helpers;

use app\modules\teamhelper\models\Module;
use app\modules\teamhelper\models\Project;
use app\modules\teamhelper\models\Ticket;

//Parse Jira ticket content
class JiraHelper {
    const TEAM_ID = 1;
    const CUSTOMER_ID = 1;
    const STATUS = 1;

    public function parseJiraSearch($json) {
        $jiraObj = json_decode($json);
        if (is_array($jiraObj->issues)) {
            foreach ($jiraObj->issues as $issue) {
                $this->parseIssue($issue);
            }
        }
    }
    
    public function parseJiraWebhook($json) {
        $events = ['issue_created', 'issue_updated'];
        $jiraObj = json_decode($json);
        if (in_array($jiraObj->issue_event_type_name, $events)) {
            $issue = $jiraObj->issue;
            $this->parseIssue($issue);
        }
    }


    private function parseIssue($issue) {
        $ticket = Ticket::findOne(['external_id' => $issue->id]);
        if ($ticket == null) {
            $ticket = new Ticket();
        }
        $ticket->external_id = $issue->id;
        $ticket->code = $issue->key;
        
        $fields = $issue->fields;
        $ticket->name = $fields->summary;
        $ticket->desc = $fields->description;
        $ticket->priority = $fields->priority == null ? null : $fields->priority->id;
        $ticket->status = $fields->status == null ? null : $fields->status->statusCategory->id;
        $ticket->reporter = $fields->reporter == null ? null : $fields->reporter->key;
        $ticket->assignee = $fields->assignee == null ? null : $fields->assignee->key;
        $ticket->estimated = $fields->timeoriginalestimate;
        
        //project
        if ($fields->project) {
            $obj_id = $fields->project->id;
            $project = Project::findOne(['external_id' => $obj_id]);
            if ($project == null) {
                $project = new Project();
                $project->external_id = $obj_id;
                $project->name = $fields->project->name;
                $project->code = $fields->project->key;
                $project->status = self::STATUS;
                $project->customer_id = self::CUSTOMER_ID;
                $project->team_id = self::TEAM_ID;
                \Yii::trace(json_encode($project->attributes));
                $project->save(false);
            }
            $ticket->project_id = $project->id;
        }
        //module / components
        if ($fields->components) {
            $obj_id = $fields->components[0]->id;
            $module = Module::findOne(['external_id' => $obj_id]);
            if ($module == null) {
                $module = new Module();
                $module->external_id = $obj_id;
                $module->name = $fields->components[0]->name;
                $module->project_id = $ticket->project_id;
                $module->team_id = self::TEAM_ID;
                $module->save(false);
            }
            $ticket->module_id = $module->id;
        }
        $ticket->team_id = self::TEAM_ID;
        
        $flag = $ticket->save(false);
    }
}
