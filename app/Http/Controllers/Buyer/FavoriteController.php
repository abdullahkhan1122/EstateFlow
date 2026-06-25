<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Property;
use Illuminate\Http\RedirectResponse;

class FavoriteController extends Controller
{
    public function toggle(Property $property): RedirectResponse
    {
        $favorite = Favorite::where('user_id', request()->user()->id)->where('property_id', $property->id)->first();

        if ($favorite) {
            $favorite->delete();

            return back()->with('status', 'Property removed from favourites.');
        }

        Favorite::create(['user_id' => request()->user()->id, 'property_id' => $property->id]);

        return back()->with('status', 'Property saved to favourites.');
    }
}
