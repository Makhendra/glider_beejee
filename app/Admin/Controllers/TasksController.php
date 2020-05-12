<?php

namespace App\Admin\Controllers;

use App\Models\GroupTask;
use App\Models\Task;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TasksController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title;

    public function __construct()
    {
        $this->title = __('messages.tasks');
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Task());

        $grid->column('title', __('messages.task_title'));
        $grid->column('group_id', __('messages.group'))->display(function ($id) {
            $group = GroupTask::find($id);
            return $group->name ?? '';
        });
        $grid->column('task_text', __('messages.task_text'));
        $grid->column('active', __('messages.active'))->switch();

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Task::findOrFail($id));

        $show->field('id', __('messages.id'));
        $show->field('group_id', __('messages.group'));
        $show->field('title', __('messages.title'));
        $show->field('type', __('messages.type'));
        $show->field('task_text', __('messages.task_text'));
        $show->field('created_at', __('messages.created_at'));
        $show->field('updated_at', __('messages.updated_at'));
        $show->field('active', __('messages.active'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Task());

        $form->select('group_id', __('messages.group'))->options(GroupTask::pluck('name','id'));
        $form->text('title', __('messages.task_title'));
        $form->number('type', __('messages.type'))->help('Не рекомендуется изменять это параметр');
        $form->textarea('task_text', __('messages.task_text'));
        $form->switch('active', __('messages.active'))->default(1);

        return $form;
    }
}
