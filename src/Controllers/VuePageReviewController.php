<?php
namespace TS2201\VuePageReview\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use TS2201\VuePageReview\Models\Page;

class VuePageReviewController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('path')) {
            $limit = 5;
            $page = Page::firstorCreate(['path' => $request->get('path')]);

            $pageNumber = 1;
            if($request->has('page')){
                $pageNumber = $request->get('page');
            }
            $reviews = $page->reviews()
                    ->orderBy(
                        config('vuepagereview.order.as'),
                        config('vuepagereview.order.by')
                    )
                    ->get();
            $reviewsPaginate = $page->reviews()
            ->orderBy(
                config('vuepagereview.order.as'),
                config('vuepagereview.order.by')
            )
            ->paginate($limit);

            return response()->json([
                'page' => $page,
                'reviews' => $reviews,
                'pagination' => [
                    'total' => $reviewsPaginate->total(),
                    'per_page' => $reviewsPaginate->perPage(),
                    'current_page' => $reviewsPaginate->currentPage(),
                    'last_page' => $reviewsPaginate->lastPage(),
                    'from' => $reviewsPaginate->firstItem(),
                    'to' => $reviewsPaginate->lastItem()
                ],
                'reviewsPaginate' => $reviewsPaginate
            ]);
          }

          return response()->json([]);
    }

    public function store(Request $request)
    {
        $page = Page::firstorCreate(['path' => $request->get('path')]);

        $review = $page->reviews()->create([
            'username' => $request->username,
            'comment' => $request->comment,
        ]);

        // Pusher::trigger('page-'.$page->id, 'new-review', $review);

        return $review;
    }
}

?>