<?php

// Vercel serverless entry-point (legacy vercel-community/php runtime).
// Forwards all requests to Laravel's front controller.
//
// NOTE: Vercel's current recommended way for Laravel is Docker + FrankenPHP
// (see Dockerfile.vercel + Caddyfile + vercel.json in this pack).
// Keep this file only if you still want to try the old community PHP runtime.
// Vercel only allows serverless function entry-points inside /api.

require __DIR__ . '/../public/index.php';
