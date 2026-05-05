@extends('admin.include.layout')
@section('title', 'Dashboard')
@section('content')

@php
    
@endphp
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="stat-card bg-white rounded-xl shadow p-6 border-l-4 border-primary transition duration-300">
            <div class="flex justify-between">
                <div>
                    <p class="text-dark">Total Users</p>
                    <h3 class="text-2xl font-bold text-dark mt-2">0</h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center">
                    <i class="fas  fa-users  text-blue-800 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-green-600 font-medium">
                    <i class="fas fa-arrow-up"></i> 12.5%
                </span>
                <span class="text-dark text-sm ml-2">Since last month</span>
            </div>
        </div>

        <div class="stat-card bg-white rounded-xl shadow p-6 border-l-4 border-secondary transition duration-300">
            <div class="flex justify-between">
                <div>
                    <p class="text-dark">Active Bookings</p>
                    <h3 class="text-2xl font-bold text-dark mt-2">0</h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-secondary/10 flex items-center justify-center">
                    <i class="fas fa-calendar-check text-secondary text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-green-600 font-medium">
                    <i class="fas fa-arrow-up"></i> 8.3%
                </span>
                <span class="text-dark text-sm ml-2">Since last month</span>
            </div>
        </div>

        <div class="stat-card bg-white rounded-xl shadow p-6 border-l-4 border-purple-500 transition duration-300">
            <div class="flex justify-between">
                <div>
                    <p class="text-dark">Total Products</p>
                    <h3 class="text-2xl font-bold text-dark mt-2">0</h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-purple-500/10 flex items-center justify-center">
                    <i class="fas fa-building text-purple-500 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-green-600 font-medium">
                    <i class="fas fa-arrow-up"></i> 5.2%
                </span>
                <span class="text-dark text-sm ml-2">Since last month</span>
            </div>
        </div>

        <div class="stat-card bg-white rounded-xl shadow p-6 border-l-4 border-yellow-400 transition duration-300">
            <div class="flex justify-between">
                <div>
                    <p class="text-dark">Total OrderRequest</p>
                    <h3 class="text-2xl font-bold text-dark mt-2">0</h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-yellow-400/10 flex items-center justify-center">
                    <i class="fas fa-star text-yellow-400 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-green-600 font-medium">
                    <i class="fas fa-arrow-up"></i> 0.3%
                </span>
                <span class="text-dark text-sm ml-2">Since last month</span>
            </div>
        </div>
    </div>


@endsection
