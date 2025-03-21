<?php

namespace App\Http\Controllers;

use App\Models\Translation;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Translation Management API",
 *     version="1.0.0",
 *     description="API for managing translations with authentication."
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class TranslationController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/translations",
     *     summary="Get all translations",
     *     tags={"Translations"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthorized"),
     * )
     */
    public function index(Request $request)
    {
        $query = Translation::query();

        if ($request->has('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('name', $request->tag);
            });
        }

        if ($request->has('key')) {
            $query->where('key', 'like', '%' . $request->key . '%');
        }

        if ($request->has('content')) {
            $query->where('value', 'like', '%' . $request->content . '%');
        }

        return response()->json($query->paginate(50));
    }

    /**
     * @OA\Post(
     *     path="/api/translations",
     *     summary="Create a new translation",
     *     tags={"Translations"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="locale_id", type="integer", example=1),
     *             @OA\Property(property="key", type="string", example="welcome"),
     *             @OA\Property(property="value", type="string", example="Welcome!"),
     *         )
     *     ),
     *     @OA\Response(response=201, description="Translation Created"),
     *     @OA\Response(response=401, description="Unauthorized"),
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'locale_id' => 'required|exists:locales,id',
            'key' => 'required|string',
            'value' => 'required|string',
            'tags' => 'nullable|array',
        ]);

        $translation = Translation::create($request->only('locale_id', 'key', 'value'));

        if ($request->has('tags')) {
            $tags = Tag::whereIn('name', $request->tags)->pluck('id');
            $translation->tags()->sync($tags);
        }

        return response()->json($translation, 201);
    }

    public function show(Translation $translation)
    {
        return response()->json($translation);
    }

    public function update(Request $request, Translation $translation)
    {
        $request->validate([
            'locale_id' => 'sometimes|exists:locales,id',
            'key' => 'sometimes|string',
            'value' => 'sometimes|string',
            'tags' => 'nullable|array',
        ]);

        $translation->update($request->only('locale_id', 'key', 'value'));

        if ($request->has('tags')) {
            $tags = Tag::whereIn('name', $request->tags)->pluck('id');
            $translation->tags()->sync($tags);
        }

        return response()->json($translation);
    }

    public function destroy(Translation $translation)
    {
        $translation->delete();
        return response()->noContent();
    }

    public function export()
    {
        $translations = Cache::remember('translations', 60, function () {
            return Translation::with('locale', 'tags')->get();
        });

        return response()->json($translations);
    }
}