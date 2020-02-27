<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Resources\CompanyResource;
use App\EmailVerification;
use App\Company;
use App\User;

class CompanyTest extends TestCase
{
    use WithFaker;

    public function testIndex()
    {
        $user = $this->createUser();

        $company = factory(Company::class)->create();

        $companyResource = (new CompanyResource($company))->resolve();

        $response = $this->actingAs($user, 'api')->json('GET', route('api.company'));

        $response->assertStatus(200);

        foreach($response->json()['data'] as $res){
            $this->assertEmpty(array_diff_key($companyResource, $res));
        }
    }

    public function testUpdateFavourite()
    {
        $user = $this->createUser();

        $company = factory(Company::class)->create();

        $data = [
            'company_ids' => [$company->id]
        ];

        $response = $this->actingAs($user, 'api')->json('POST', route('api.update_favourite', $user->id), $data);

        $response->assertStatus(200);

        $favouriteIds = $user->favourite->pluck('id')->toArray();

        $this->assertTrue(in_array($company->id, $favouriteIds));
    }

    public function createUser()
    {
        $user = factory(User::class)->create();
                
        EmailVerification::create([
            'email' => $user->email,
            'token' => str_random(32),
            'expire' => date('Y-m-d H:i:s', strtotime('+1 day', time()))
        ]);

        return $user;
    }
}