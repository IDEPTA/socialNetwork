<?php

namespace App\Orchid\Layouts\Post;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;

class PostTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'posts';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make("id")
                ->sort()
                ->filter(),
            TD::make("title", "Заголовок")
                ->sort()
                ->filter(),
            TD::make("text", "Текст")
                ->sort()
                ->filter(),

            TD::make("user", "ФИО")
                ->sort()
                ->filter()
                ->render(fn($model) => Link::make($model->user->name)),
            TD::make("email", "E-mail")
                ->sort()
                ->filter()
                ->render(fn($model) => Link::make($model->user->email)),

            TD::make("created_at", "Дата создания")
                ->sort()
                ->filter()
                ->defaultHidden(),
            TD::make("updated_at", "Дата обновления")
                ->sort()
                ->filter()
                ->defaultHidden(),

            TD::make(("Действия"))
                ->align(TD::ALIGN_CENTER)
                ->render(
                    fn($model) => DropDown::make()
                        ->icon("bi.list-ul")
                        ->list([
                            Button::make("Удалить")
                                ->icon('bs.trash3')
                                ->confirm("Вы уверены, что хотите удалить эту запись ?"),
                            // ->method('remove', ["id" => $model->id]),

                            Link::make('Изменить')
                                ->icon("bi.pen"),
                            // ->route("platform.edit.post", $model),

                            Link::make('Подробнее')
                                ->icon("bi.eye")
                                ->route("platform.posts.show", $model)
                        ])
                ),
        ];
    }
}
