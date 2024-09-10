<?php

namespace App\Orchid\Screens\Post;

use App\Models\Post;
use App\Models\Comment;
use App\Models\PostLike;
use Orchid\Screen\Sight;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use App\Orchid\Layouts\Charts\ChartBar;
use App\Orchid\Layouts\Charts\ChartLine;
use App\Orchid\Layouts\Charts\ChartPie;
use App\Orchid\Layouts\Comment\CommentsTable;
use App\Orchid\Layouts\Like\Post\PostLikeTable;

class PostShowScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Post $post): iterable
    {
        return [
            "post" => $post,
            "likes" => PostLike::with("user")->where("post_id", $post->id)->paginate(7),
            "PieLike" => PostLike::where("post_id", $post->id)
                ->countForGroup("feedback_type")
                ->toChart(
                    fn($e) => $e ? "Лайк" : "Дизлайк"
                ),

            "LineLike" => [
                PostLike::where("post_id", $post->id)
                    ->where("feedback_type", true)
                    ->countByDays()
                    ->toChart("Лайки"),
                PostLike::where("post_id", $post->id)
                    ->where("feedback_type", false)
                    ->countByDays()
                    ->toChart("Дизлайки")
            ],
            "comments"  => Comment::with("user")->where("post_id", $post->id)->paginate(7)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Подробнее';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::legend('post', [
                Sight::make('id'),
                Sight::make('title', 'Заголовок'),
                Sight::make('text', "Текст"),
                Sight::make("images", "Изображения")
                    ->render(
                        function ($e) {
                            if (json_decode($e->images) == null) {
                                echo "Изображений нет";
                            } else {
                                echo "<p>";
                                foreach (json_decode($e->images) as $images) {
                                    echo "<img src = {$images} width=200px>";
                                }
                                echo "</p>";
                            }
                        }
                    ),
                Sight::make('user_id', "Ф.И.О")
                    ->render(fn($model) => $model->user->name),
                Sight::make('user_id', "E-mail")
                    ->render(fn($model) => $model->user->email),
            ]),

            Layout::split([
                CommentsTable::class,
                PostLikeTable::class
            ])->ratio('70/30'),

            Layout::split([
                ChartLine::make("LineLike", "Лайки дизлайки"),
                ChartPie::make("PieLike", "Соотношение лайков и дизлайков"),
            ])->ratio('70/30'),
        ];
    }
}
