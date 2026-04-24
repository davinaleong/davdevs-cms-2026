<?php

namespace App\Http\Requests;

use App\Enums\PostType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePostRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'meta' => $this->decodeJsonField('meta', []),
            'blocks' => $this->decodeJsonField('blocks', []),
            'tool' => $this->decodeJsonField('tool', []),
        ]);
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'post_type' => ['required', Rule::enum(PostType::class)],
            'slug' => ['required', 'string', 'max:255', 'unique:posts,slug'],
            'excerpt' => ['nullable', 'string'],
            'content_md' => ['required', 'string'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'published_at' => ['nullable', 'date'],
            'meta' => ['nullable', 'array'],
            'meta.meta_title' => ['nullable', 'string', 'max:255'],
            'meta.meta_description' => ['nullable', 'string'],
            'meta.canonical_url' => ['nullable', 'url', 'max:255'],
            'meta.og_image' => ['nullable', 'string', 'max:255'],
            'meta.json_ld' => ['nullable', 'array'],
            'blocks' => ['nullable', 'array'],
            'blocks.*.type' => ['required_with:blocks', 'string', 'max:80'],
            'blocks.*.position' => ['nullable', 'integer', 'min:1'],
            'blocks.*.payload' => ['required_with:blocks', 'array'],
            'tool' => ['nullable', 'array'],
            'tool.component_name' => ['required_with:tool', 'string', 'max:255'],
            'tool.bundle_path' => ['required_with:tool', 'string', 'max:255'],
            'tool.props' => ['nullable', 'array'],
            'tool.is_active' => ['nullable', 'boolean'],
        ];
    }

    /**
     * @return array<mixed>
     */
    private function decodeJsonField(string $field, array $fallback): array
    {
        $value = $this->input($field);

        if (is_array($value)) {
            return $value;
        }

        if (! is_string($value) || trim($value) === '') {
            return $fallback;
        }

        $decoded = json_decode($value, true);

        return is_array($decoded) ? $decoded : $fallback;
    }
}
