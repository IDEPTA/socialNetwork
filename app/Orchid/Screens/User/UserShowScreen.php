<?php

namespace App\Orchid\Screens\User;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Models\PostLike;
use Orchid\Screen\Sight;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use App\Orchid\Layouts\Charts\ChartLine;
use App\Orchid\Layouts\Charts\ChartPie;
use App\Orchid\Layouts\Comment\UserCommentTable;
use App\Orchid\Layouts\Post\UserPostTable;

class UserShowScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(User $user): iterable
    {
        $posts = Post::with("user")->where("user_id", $user->id)->filters()->paginate(5);
        $likes = PostLike::with(["post", "user"])->where("user_id", $user->id)->filters()->paginate(5);
        $comments = Comment::with(["post", "user"])->where("user_id", $user->id)->filters()->paginate(5);
        $countLikes = PostLike::where("user_id", $user->id)->count();
        $countPosts = Post::where("user_id", $user->id)->count();
        $countComments = Comment::where("user_id", $user->id)->count();

        return [
            "user" => $user,
            "posts" => $posts,
            "likes" => $likes,
            "comments" => $comments,

            "UserActivity" => [

                PostLike::where("user_id", $user->id)
                    ->countByDays()
                    ->toChart("Лайки/Дизлайки"),
                Post::where("user_id", $user->id)
                    ->countByDays()
                    ->toChart("Посты"),
                Comment::where("user_id", $user->id)
                    ->countByDays()
                    ->toChart("Комментарии")
            ],

            "PieActivity" => [
                [
                    'values' => [$countLikes, $countPosts, $countComments],
                    'labels' => ['Оценки', 'Посты', 'Комментарии'],
                ],
            ],
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
            Layout::legend('user', [
                Sight::make('id'),
                Sight::make('name', 'Ф.И.О'),
                Sight::make('email', 'E-mail'),
                Sight::make('2fa', 'статус 2FA')
                    ->render(
                        fn($user) => $user->telegram_username == false ?
                            "Отключена" :
                            "Включена"
                    ),
                Sight::make('telegram_username', 'Имя пользователя телеграмм')
                    ->render(
                        fn($user) => $user->telegram_username == null ?
                            "Не установлен" :
                            $user->telegram_username
                    ),
                Sight::make('telegram_chat_id', 'Телеграмм id')
                    ->render(
                        fn($user) => $user->telegram_chat_id == null ?
                            "Не установлен" :
                            $user->telegram_chat_id
                    ),
                Sight::make('email_verified_at', 'Верификация аккаунта')
                    ->render(
                        fn($user) =>
                        $user->email_verified_at == null ?
                            "Не верифицирован" :
                            $user->email_verified_at
                    ),
                Sight::make('created_at', 'Дата создания'),
                Sight::make('updated_at', 'Дата обновления'),
            ]),

            Layout::split([
                UserPostTable::class,
                UserCommentTable::class
            ])->ratio('50/50'),

            Layout::split([
                ChartLine::make("UserActivity", "Активность пользователя"),
                ChartPie::make("PieActivity", "Общая статистика")
            ])->ratio('60/40'),
        ];
    }
}
