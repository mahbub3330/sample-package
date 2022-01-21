<?php

namespace Gglink\Sample\Http\Controllers;

use App\Http\Controllers\Controller;
use Gglink\Sample\Models\User;
use Gglink\Sample\Requests\UserRequest;
use Gglink\Sample\Services\FileUploadRemoveService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->get('Filter'), function ($query) use ($request){
                return $query->filterData($request->get('Filter'));
            })->limit(10)->get();
        return view('sample::user.index', compact('users'));
    }

    /**
     * @return Application|Factory|View
     */

    public function create()
    {
        return view('sample::user.create');
    }

    /**
     * @param User $user
     * @return Application|Factory|View|RedirectResponse
     */

    public function store(UserRequest $request)
    {
        try {
            $user = new User();
            $user->fill($request->except('Avatar'))->save();
            if ($request->get('Avatar')) {
                $image_path = FileUploadRemoveService::fileUpload('users', $request->get('images'), 'image');
                $user->update(['images' => $image_path]);
            }
            return view('sample::user.show', ['user' => $user, 'message' => 'User Updated successfully']);
        } catch (\Exception $exception) {
            return redirect()->back()->with($exception->getMessage());
        }
    }

    /**
     * @param User $user
     * @param Request $request
     * @return Application|Factory|View
     */
    public function show(User $user, Request $request)
    {
        $user = $user->findOrFail($request->get('id'));
        return view('sample:user.show', compact('user'));
    }

    /**
     * @param User $user
     * @param UserRequest $request
     * @return RedirectResponse|void
     */
    public function update(User $user, UserRequest $request)
    {
        try {
            $user = $user->findOrFail($request->get('id'));
            $user->fill($request->except('Avatar'))->update();
            if ($request->get('Avatar') != $user->Avatar) {
                FileUploadRemoveService::removeFile($user->Avatar);
                $image_path = FileUploadRemoveService::fileUpload('users', $request->get('images'), 'image');
                $user->update(['images' => $image_path]);
                return redirect()->back()
                    ->with(['user' => $user, 'message' => 'User Updated successfully']);
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with($exception->getMessage());
        }
    }

    /**
     * @param User $user
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(User $user, Request $request)
    {
        try {
            $user->findOrFail($request->get('id'));
            $user->delete();
            return redirect()->route('index')->with('success', 'User deleted successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with($exception->getMessage());
        }
    }

    /**
     * @param User $user
     * @param Request $request
     * @return Application|Factory|View
     */

    public function profileUser(User $user, Request $request)
    {
        $user = $user->findOrFail($request->get('id'));
        return view('sample::user.profile_user', ['user' => $user, 'message' => 'User Updated successfully']);
    }


}
