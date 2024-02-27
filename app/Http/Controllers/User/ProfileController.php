<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function updateAvatar(Request $request, User $user)
    {
        // Валидация и обработка загруженного изображения...
        // ...

        // Сохраняем изображение в папку storage/app/public/avatars
        Storage::disk('local')->put("avatars/$user->id.jpg", file_get_contents($request->file('image')->path()));
        $request->file('image')->storeAs('public/avatars', $user->id . '.jpg');
        // Обновляем аватар пользователя в БД
        $user->avatar = "avatars/$user->id.jpg";
        $user->save();

        return redirect()->back()->with('success', 'Аватар успешно обновлен!');
    }
}
