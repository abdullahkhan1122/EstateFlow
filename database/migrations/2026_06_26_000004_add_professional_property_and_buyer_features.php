<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('photo_url')->nullable()->after('bio');
            $table->json('languages')->nullable()->after('photo_url');
            $table->json('specialities')->nullable()->after('languages');
            $table->json('service_areas')->nullable()->after('specialities');
            $table->json('social_links')->nullable()->after('service_areas');
            $table->string('office_name')->nullable()->after('social_links');
        });

        Schema::table('properties', function (Blueprint $table) {
            $table->string('reference_number')->nullable()->unique()->after('slug');
            $table->string('area')->nullable()->index()->after('city');
            $table->string('neighbourhood')->nullable()->index()->after('area');
            $table->decimal('original_price', 12, 2)->nullable()->after('price');
            $table->date('availability_date')->nullable()->after('zip_code');
            $table->date('listing_expiry_date')->nullable()->after('availability_date');
            $table->string('furnishing_status')->default('Unfurnished')->index()->after('listing_expiry_date');
            $table->string('condition')->nullable()->after('furnishing_status');
            $table->string('community')->nullable()->after('condition');
            $table->unsignedInteger('floor_number')->nullable()->after('community');
            $table->unsignedInteger('total_floors')->nullable()->after('floor_number');
            $table->unsignedSmallInteger('year_built')->nullable()->index()->after('total_floors');
            $table->string('energy_rating')->nullable()->after('year_built');
            $table->decimal('latitude', 10, 7)->nullable()->index()->after('energy_rating');
            $table->decimal('longitude', 10, 7)->nullable()->index()->after('latitude');
            $table->json('amenities')->nullable()->after('features');
            $table->string('video_url')->nullable()->after('amenities');
            $table->string('virtual_tour_url')->nullable()->after('video_url');
            $table->string('floor_plan_path')->nullable()->after('virtual_tour_url');
            $table->boolean('has_open_house')->default(false)->index()->after('is_featured');
            $table->timestamp('open_house_at')->nullable()->index()->after('has_open_house');
            $table->boolean('is_price_reduced')->default(false)->index()->after('open_house_at');
            $table->string('availability_status')->default('Available')->index()->after('is_price_reduced');
            $table->string('approval_status')->default('approved')->index()->after('availability_status');
            $table->text('internal_notes')->nullable()->after('approval_status');
            $table->text('rejection_reason')->nullable()->after('internal_notes');
        });

        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['user_id', 'property_id']);
        });

        Schema::create('saved_searches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->json('filters');
            $table->boolean('notify_matches')->default(true);
            $table->timestamps();
        });

        Schema::create('property_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->string('session_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
            $table->index(['property_id', 'created_at']);
        });

        Schema::create('property_comparisons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('session_id')->nullable()->index();
            $table->json('property_ids');
            $table->timestamps();
        });

        Schema::create('viewing_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('agent_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('preferred_date');
            $table->time('preferred_time');
            $table->string('viewing_type')->default('in_person');
            $table->string('status')->default('pending')->index();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('message')->nullable();
            $table->text('agent_notes')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('notification_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->boolean('email_inquiries')->default(true);
            $table->boolean('email_viewings')->default(true);
            $table->boolean('email_saved_search_matches')->default(true);
            $table->boolean('database_notifications')->default(true);
            $table->timestamps();
            $table->unique('user_id');
        });

        Schema::create('property_price_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->decimal('previous_price', 12, 2);
            $table->decimal('new_price', 12, 2);
            $table->foreignId('changed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('changed_at');
            $table->timestamps();
        });

        Schema::create('lead_sources', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::table('property_inquiries', function (Blueprint $table) {
            $table->foreignId('assigned_agent_id')->nullable()->after('property_id')->constrained('users')->nullOnDelete();
            $table->foreignId('lead_source_id')->nullable()->after('assigned_agent_id')->constrained()->nullOnDelete();
            $table->string('status')->default('new')->index()->after('preferred_contact');
            $table->string('priority')->default('normal')->index()->after('status');
            $table->timestamp('follow_up_at')->nullable()->after('priority');
            $table->timestamp('last_contacted_at')->nullable()->after('follow_up_at');
            $table->string('next_action')->nullable()->after('last_contacted_at');
            $table->string('lost_reason')->nullable()->after('next_action');
            $table->boolean('is_converted')->default(false)->after('lost_reason');
            $table->text('internal_notes')->nullable()->after('message');
        });

        Schema::create('inquiry_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_inquiry_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->text('note');
            $table->timestamps();
        });

        Schema::create('inquiry_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_inquiry_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type');
            $table->text('description');
            $table->json('metadata')->nullable();
            $table->timestamps();
        });

        Schema::create('inquiry_tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('inquiry_tag', function (Blueprint $table) {
            $table->foreignId('property_inquiry_id')->constrained()->cascadeOnDelete();
            $table->foreignId('inquiry_tag_id')->constrained()->cascadeOnDelete();
            $table->primary(['property_inquiry_id', 'inquiry_tag_id']);
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('group')->index();
            $table->string('key')->index();
            $table->json('value')->nullable();
            $table->timestamps();
            $table->unique(['group', 'key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('inquiry_tag');
        Schema::dropIfExists('inquiry_tags');
        Schema::dropIfExists('inquiry_activities');
        Schema::dropIfExists('inquiry_notes');
        Schema::table('property_inquiries', function (Blueprint $table) {
            $table->dropConstrainedForeignId('assigned_agent_id');
            $table->dropConstrainedForeignId('lead_source_id');
            $table->dropColumn(['status', 'priority', 'follow_up_at', 'last_contacted_at', 'next_action', 'lost_reason', 'is_converted', 'internal_notes']);
        });
        Schema::dropIfExists('lead_sources');
        Schema::dropIfExists('property_price_histories');
        Schema::dropIfExists('notification_preferences');
        Schema::dropIfExists('viewing_requests');
        Schema::dropIfExists('property_comparisons');
        Schema::dropIfExists('property_views');
        Schema::dropIfExists('saved_searches');
        Schema::dropIfExists('favorites');

        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn([
                'reference_number', 'area', 'neighbourhood', 'original_price', 'availability_date', 'listing_expiry_date',
                'furnishing_status', 'condition', 'community', 'floor_number', 'total_floors', 'year_built',
                'energy_rating', 'latitude', 'longitude', 'amenities', 'video_url', 'virtual_tour_url',
                'floor_plan_path', 'has_open_house', 'open_house_at', 'is_price_reduced', 'availability_status',
                'approval_status', 'internal_notes', 'rejection_reason',
            ]);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['photo_url', 'languages', 'specialities', 'service_areas', 'social_links', 'office_name']);
        });
    }
};
