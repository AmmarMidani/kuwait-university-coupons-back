@extends('errors::minimal')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message', "You are not authorized! 🔐")
@section('details', "You don’t have permission to access this page. Go Home!")
