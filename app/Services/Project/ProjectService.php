<?php
/**
 * Created by PhpStorm.
 * User: m.marzban
 * Date: 12/7/2019
 * Time: 8:26 AM
 */

namespace App\Services\Project;


use App\Project;
use App\ValueObject\CreateProject;
use App\ValueObject\UpdateProject;


/**
 * Class ProjectService
 * @package App\Services\Project
 */
class ProjectService
{
    /**
     * @param bool $paginate
     * @return mixed
     */
    public function all($paginate = false)
    {
        $projects = Project::latest();
        if ($paginate){
            return $projects->paginate();
        }
        return $projects->get();
    }

    /**
     * @param $title
     * @return mixed
     */
    public function findByTitle($title)
    {
        return Project::where('title', $title)->first();
    }

    /**
     * @param $projectId
     * @return mixed
     */
    public function findById($projectId)
    {
        return Project::where('id', $projectId)->first();
    }

    /**
     * @param CreateProject $project
     * @return Project
     */
    public function create(CreateProject $project) :Project
    {
        return Project::create([
            'title' => $project->getTitle(),
            'user_id' => auth()->id(),
        ]);
    }

    /**
     * @param UpdateProject $updateProject
     * @param Project $project
     */
    public function update(UpdateProject $updateProject, Project $project)
    {
        $project->update([
            'title' => $updateProject->getTitle(),
            'user_id' => auth()->id(),
        ]);
    }
}