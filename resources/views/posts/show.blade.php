@php
    $postType = $post->post_type?->value ?? $post->post_type;
    $postTypeView = 'posts.' . $postType;
@endphp

@extends('layouts.app')

@section('title', $post->meta?->meta_title ?? $post->title)
@section('meta_description', $post->meta?->meta_description ?? $post->excerpt)
@section('canonical', $post->meta?->canonical_url ?? request()->url())
@section('og_title', $post->meta?->meta_title ?? $post->title)
@section('og_description', $post->meta?->meta_description ?? $post->excerpt)
@section('og_image', $post->meta?->og_image ?? '')

@section('content')
    @if (view()->exists($postTypeView))
        @include($postTypeView, ['post' => $post])
    @else
        @include('posts.default', ['post' => $post])
    @endif
@endsection
