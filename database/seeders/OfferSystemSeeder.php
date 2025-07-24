<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Offer;
use App\Models\OfferItem;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;

class OfferSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating offer system sample data...');

        // Get the first user (assuming it exists from previous seeders)
        $user = User::first();
        if (!$user) {
            $this->command->error('No users found. Please run UserSeeder first.');
            return;
        }

        // Create sample companies
        $companies = [
            [
                'name' => 'TechCorp Solutions',
                'email' => 'contact@techcorp.com',
                'phone' => '+1-555-0123',
                'address' => '123 Tech Street',
                'city' => 'San Francisco',
                'state' => 'CA',
                'zip' => '94102',
                'country' => 'USA',
                'website' => 'https://techcorp.com',
                'status' => 'active',
            ],
            [
                'name' => 'Digital Dynamics',
                'email' => 'hello@digitaldynamics.com',
                'phone' => '+1-555-0456',
                'address' => '456 Innovation Ave',
                'city' => 'Austin',
                'state' => 'TX',
                'zip' => '73301',
                'country' => 'USA',
                'website' => 'https://digitaldynamics.com',
                'status' => 'active',
            ],
            [
                'name' => 'Creative Studios Ltd',
                'email' => 'info@creativestudios.co.uk',
                'phone' => '+44-20-7123-4567',
                'address' => '789 Design Lane',
                'city' => 'London',
                'country' => 'UK',
                'status' => 'active',
            ],
        ];

        foreach ($companies as $companyData) {
            Company::create($companyData);
        }

        $this->command->info('Created 3 sample companies');

        // Create sample customers
        $customers = [
            [
                'name' => 'John Smith',
                'email' => 'john.smith@techcorp.com',
                'phone' => '+1-555-0111',
                'company_id' => 1,
                'status' => 'active',
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@digitaldynamics.com',
                'phone' => '+1-555-0222',
                'company_id' => 2,
                'status' => 'active',
            ],
            [
                'name' => 'Michael Brown',
                'email' => 'michael.brown@creativestudios.co.uk',
                'phone' => '+44-20-7123-4568',
                'company_id' => 3,
                'status' => 'active',
            ],
            [
                'name' => 'Emily Davis',
                'email' => 'emily.davis@freelancer.com',
                'phone' => '+1-555-0333',
                'company_id' => null, // Independent freelancer
                'status' => 'active',
            ],
        ];

        foreach ($customers as $customerData) {
            Customer::create($customerData);
        }

        $this->command->info('Created 4 sample customers');

        // Get existing projects
        $projects = Project::all();
        if ($projects->isEmpty()) {
            $this->command->warn('No projects found. Offers will be created without project association.');
        }

        // Create sample offers
        $offers = [
            [
                'name' => 'Website Redesign Proposal',
                'description' => 'Complete redesign of corporate website with modern UI/UX, responsive design, and improved performance.',
                'customer_id' => 1,
                'project_id' => $projects->isNotEmpty() ? $projects->first()->id : null,
                'created_by_user_id' => $user->id,
                'status' => 'sent',
                'valid_until' => Carbon::now()->addDays(30),
                'notes' => 'Client interested in modern design with focus on mobile experience.',
                'sent_at' => Carbon::now()->subDays(5),
            ],
            [
                'name' => 'Mobile App Development',
                'description' => 'Native iOS and Android app development with backend API integration.',
                'customer_id' => 2,
                'project_id' => $projects->count() > 1 ? $projects->skip(1)->first()->id : null,
                'created_by_user_id' => $user->id,
                'status' => 'draft',
                'valid_until' => Carbon::now()->addDays(45),
                'notes' => 'Requires detailed technical specifications before final pricing.',
            ],
            [
                'name' => 'Brand Identity Package',
                'description' => 'Complete brand identity design including logo, business cards, letterhead, and brand guidelines.',
                'customer_id' => 3,
                'project_id' => null,
                'created_by_user_id' => $user->id,
                'status' => 'accepted',
                'valid_until' => Carbon::now()->addDays(15),
                'notes' => 'Rush job - client needs delivery in 2 weeks.',
                'sent_at' => Carbon::now()->subDays(10),
                'accepted_at' => Carbon::now()->subDays(3),
            ],
            [
                'name' => 'E-commerce Platform Setup',
                'description' => 'Setup and customization of e-commerce platform with payment integration and inventory management.',
                'customer_id' => 4,
                'project_id' => null,
                'created_by_user_id' => $user->id,
                'status' => 'rejected',
                'valid_until' => Carbon::now()->subDays(5),
                'notes' => 'Client decided to go with a different solution.',
                'sent_at' => Carbon::now()->subDays(15),
                'rejected_at' => Carbon::now()->subDays(5),
            ],
        ];

        foreach ($offers as $offerData) {
            $offer = Offer::create($offerData);

            // Create sample offer items for each offer
            $this->createOfferItems($offer);
        }

        $this->command->info('Created 4 sample offers with line items');
        $this->command->info('Offer system sample data created successfully!');
    }

    /**
     * Create sample offer items for an offer
     */
    private function createOfferItems(Offer $offer)
    {
        $itemSets = [
            'Website Redesign Proposal' => [
                ['name' => 'UI/UX Design', 'description' => 'User interface and user experience design', 'hours' => 40, 'rate_per_hour' => 75],
                ['name' => 'Frontend Development', 'description' => 'HTML, CSS, JavaScript implementation', 'hours' => 60, 'rate_per_hour' => 85],
                ['name' => 'Backend Development', 'description' => 'Server-side functionality and database', 'hours' => 35, 'rate_per_hour' => 90],
                ['name' => 'Testing & Deployment', 'description' => 'Quality assurance and production deployment', 'hours' => 15, 'rate_per_hour' => 70],
            ],
            'Mobile App Development' => [
                ['name' => 'iOS App Development', 'description' => 'Native iOS application development', 'hours' => 120, 'rate_per_hour' => 95],
                ['name' => 'Android App Development', 'description' => 'Native Android application development', 'hours' => 110, 'rate_per_hour' => 90],
                ['name' => 'Backend API', 'description' => 'RESTful API development and integration', 'hours' => 50, 'rate_per_hour' => 85],
                ['name' => 'App Store Submission', 'description' => 'Preparation and submission to app stores', 'hours' => 10, 'rate_per_hour' => 75],
            ],
            'Brand Identity Package' => [
                ['name' => 'Logo Design', 'description' => 'Primary logo and variations', 'hours' => 25, 'rate_per_hour' => 80],
                ['name' => 'Business Collateral', 'description' => 'Business cards, letterhead, envelopes', 'hours' => 15, 'rate_per_hour' => 70],
                ['name' => 'Brand Guidelines', 'description' => 'Comprehensive brand usage guidelines', 'hours' => 12, 'rate_per_hour' => 75],
            ],
            'E-commerce Platform Setup' => [
                ['name' => 'Platform Setup', 'description' => 'E-commerce platform installation and configuration', 'hours' => 20, 'rate_per_hour' => 80],
                ['name' => 'Theme Customization', 'description' => 'Custom theme development and styling', 'hours' => 35, 'rate_per_hour' => 75],
                ['name' => 'Payment Integration', 'description' => 'Payment gateway setup and testing', 'hours' => 15, 'rate_per_hour' => 85],
                ['name' => 'Product Setup', 'description' => 'Initial product catalog setup', 'hours' => 12, 'rate_per_hour' => 60],
            ],
        ];

        $items = $itemSets[$offer->name] ?? [
            ['name' => 'Consultation', 'description' => 'Initial project consultation', 'hours' => 5, 'rate_per_hour' => 100],
            ['name' => 'Development', 'description' => 'Main development work', 'hours' => 40, 'rate_per_hour' => 85],
        ];

        foreach ($items as $index => $itemData) {
            $total = $itemData['hours'] * $itemData['rate_per_hour'];
            
            OfferItem::create([
                'name' => $itemData['name'],
                'description' => $itemData['description'],
                'hours' => $itemData['hours'],
                'rate_per_hour' => $itemData['rate_per_hour'],
                'total' => $total,
                'offer_id' => $offer->id,
                'sort_order' => $index + 1,
            ]);
        }

        // Update offer total price
        $offer->update(['price' => $offer->calculateTotal()]);
    }
}
