<?php

namespace App\Admin\Controllers;

use App\Models\GroupTask;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class GroupsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title;

    public function __construct()
    {
        $this->title = __('messages.groups');
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new GroupTask());
        $grid->column('name', __('messages.name'));
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
        $show = new Show(GroupTask::findOrFail($id));

        $show->field('id', __('messages.id'));
        $show->field('name', __('messages.name'));
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
        $form = new Form(new GroupTask());

        $form->tab(
            __('messages.group'),
            function ($form) {
                $form->text('name', __('messages.name'));
                $form->switch('active', __('messages.active'))->default(1);
            });
        $form->tab(
            __('messages.tasks'),
            function ($form) {
                $form->hasMany(
                    'tasks',
                    function (Form\NestedForm $form) {
                        $form->text('title', __('messages.task_title'));
                        $form->textarea('task_text', __('messages.task_text'));
                        $form->switch('active', __('messages.active'));
                    }
                );
            }
        );

        return $form;
    }
}
