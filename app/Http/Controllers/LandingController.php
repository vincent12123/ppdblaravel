<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Models\Announcement;
use App\Models\InfoCard;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // Ambil 3 jurusan utama untuk showcase
        $majors = Major::take(3)->get();

        // Ambil pengumuman aktif terbaru
        $announcements = Announcement::where('is_active', true)
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        // Ambil info cards yang aktif
        $infoCards = InfoCard::active()->ordered()->get();

        return view('landing.index', compact('majors', 'announcements', 'infoCards'));
    }

    public function majors()
    {
        $majors = Major::all();
        return view('landing.majors', compact('majors'));
    }

    public function majorDetail($slug)
    {
        $major = Major::where('slug', $slug)->firstOrFail();
        return view('landing.major-detail', compact('major'));
    }

    public function announcements()
    {
        $announcements = Announcement::where('is_active', true)
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return view('landing.announcements', compact('announcements'));
    }

    public function announcementDetail($id)
    {
        $announcement = Announcement::where('is_active', true)
            ->where('published_at', '<=', now())
            ->findOrFail($id);

        return view('landing.announcement-detail', compact('announcement'));
    }
}
