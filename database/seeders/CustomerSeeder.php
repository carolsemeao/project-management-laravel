<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing customers to avoid duplicates (use delete instead of truncate due to foreign keys)
        Customer::query()->delete();

        // Create some companies first if they don't exist
        $companies = Company::all();
        if ($companies->isEmpty()) {
            $this->command->info('Creating sample companies...');
            
            $companyData = [
                [
                    'name' => 'TechCorp Solutions',
                    'email' => 'contact@techcorp.com',
                    'phone' => '+1 (555) 100-1000',
                    'address' => '100 Technology Drive',
                    'city' => 'San Francisco',
                    'state' => 'CA',
                    'zip' => '94105',
                    'country' => 'USA',
                    'website' => 'https://techcorp.com',
                    'notes' => 'Leading technology solutions provider',
                    'status' => true,
                ],
                [
                    'name' => 'Innovate Inc',
                    'email' => 'hello@innovate.com',
                    'phone' => '+1 (555) 200-2000',
                    'address' => '200 Innovation Boulevard',
                    'city' => 'Austin',
                    'state' => 'TX',
                    'zip' => '73301',
                    'country' => 'USA',
                    'website' => 'https://innovate.com',
                    'notes' => 'Startup accelerator and venture capital',
                    'status' => true,
                ],
                [
                    'name' => 'Enterprise Systems',
                    'email' => 'info@enterprise.org',
                    'phone' => '+1 (555) 300-3000',
                    'address' => '300 Enterprise Way',
                    'city' => 'New York',
                    'state' => 'NY',
                    'zip' => '10001',
                    'country' => 'USA',
                    'website' => 'https://enterprise.org',
                    'notes' => 'Large enterprise software solutions',
                    'status' => true,
                ],
                [
                    'name' => 'Creative Studio',
                    'email' => 'team@creative.studio',
                    'phone' => '+1 (555) 400-4000',
                    'address' => '400 Creative Lane',
                    'city' => 'Los Angeles',
                    'state' => 'CA',
                    'zip' => '90210',
                    'country' => 'USA',
                    'website' => 'https://creative.studio',
                    'notes' => 'Digital creative agency',
                    'status' => true,
                ],
                [
                    'name' => 'HealthTech Partners',
                    'email' => 'contact@healthtech.med',
                    'phone' => '+1 (555) 500-5000',
                    'address' => '500 Medical Center Drive',
                    'city' => 'Boston',
                    'state' => 'MA',
                    'zip' => '02101',
                    'country' => 'USA',
                    'website' => 'https://healthtech.med',
                    'notes' => 'Healthcare technology solutions',
                    'status' => true,
                ],
            ];

            foreach ($companyData as $company) {
                Company::create($company);
            }
            
            $companies = Company::all();
            $this->command->info('Created ' . $companies->count() . ' companies.');
        }

        $customers = [
            [
                'name' => 'John Smith',
                'email' => 'john.smith@techcorp.com',
                'phone' => '+1 (555) 123-4567',
                'address' => '123 Main Street',
                'city' => 'New York',
                'state' => 'NY',
                'zip' => '10001',
                'country' => 'USA',
                'status' => true,
                'notes' => 'Long-term client with multiple projects. Prefers email communication.',
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@innovate.com',
                'phone' => '+1 (555) 234-5678',
                'address' => '456 Oak Avenue',
                'city' => 'Los Angeles',
                'state' => 'CA',
                'zip' => '90210',
                'country' => 'USA',
                'status' => true,
                'notes' => 'Startup founder looking for web development services.',
            ],
            [
                'name' => 'Michael Brown',
                'email' => 'michael.brown@enterprise.org',
                'phone' => '+1 (555) 345-6789',
                'address' => '789 Pine Road',
                'city' => 'Chicago',
                'state' => 'IL',
                'zip' => '60601',
                'country' => 'USA',
                'status' => true,
                'notes' => 'Enterprise client requiring custom software solutions.',
            ],
            [
                'name' => 'Emily Davis',
                'email' => 'emily.davis@creative.studio',
                'phone' => '+1 (555) 456-7890',
                'address' => '321 Elm Street',
                'city' => 'Austin',
                'state' => 'TX',
                'zip' => '73301',
                'country' => 'USA',
                'status' => true,
                'notes' => 'Creative agency needing e-commerce platform development.',
            ],
            [
                'name' => 'David Wilson',
                'email' => 'david.wilson@consulting.biz',
                'phone' => '+1 (555) 567-8901',
                'address' => '654 Maple Drive',
                'city' => 'Seattle',
                'state' => 'WA',
                'zip' => '98101',
                'country' => 'USA',
                'status' => false,
                'notes' => 'Former client, project completed. May return for future work.',
            ],
            [
                'name' => 'Lisa Anderson',
                'email' => 'lisa.anderson@healthcare.med',
                'phone' => '+1 (555) 678-9012',
                'address' => '987 Cedar Lane',
                'city' => 'Miami',
                'state' => 'FL',
                'zip' => '33101',
                'country' => 'USA',
                'status' => true,
                'notes' => 'Healthcare sector client requiring HIPAA-compliant solutions.',
            ],
            [
                'name' => 'Robert Taylor',
                'email' => 'robert.taylor@finance.corp',
                'phone' => '+1 (555) 789-0123',
                'address' => '147 Birch Boulevard',
                'city' => 'Boston',
                'state' => 'MA',
                'zip' => '02101',
                'country' => 'USA',
                'status' => true,
                'notes' => 'Financial services client with strict security requirements.',
            ],
            [
                'name' => 'Jennifer Martinez',
                'email' => 'jennifer.martinez@retail.shop',
                'phone' => '+1 (555) 890-1234',
                'address' => '258 Spruce Court',
                'city' => 'Denver',
                'state' => 'CO',
                'zip' => '80201',
                'country' => 'USA',
                'status' => true,
                'notes' => 'Retail business owner looking for inventory management system.',
            ],
            [
                'name' => 'Christopher Lee',
                'email' => 'christopher.lee@education.edu',
                'phone' => '+1 (555) 901-2345',
                'address' => '369 Willow Way',
                'city' => 'Portland',
                'state' => 'OR',
                'zip' => '97201',
                'country' => 'USA',
                'status' => true,
                'notes' => 'Educational institution requiring learning management system.',
            ],
            [
                'name' => 'Amanda White',
                'email' => 'amanda.white@nonprofit.org',
                'phone' => '+1 (555) 012-3456',
                'address' => '741 Poplar Place',
                'city' => 'Phoenix',
                'state' => 'AZ',
                'zip' => '85001',
                'country' => 'USA',
                'status' => false,
                'notes' => 'Non-profit organization with limited budget. Project on hold.',
            ],
        ];

        foreach ($customers as $customerData) {
            // Assign a random company to each customer
            $customerData['company_id'] = $companies->random()->id;
            
            Customer::create($customerData);
        }

        $this->command->info('Customer seeder completed successfully!');
    }
}
