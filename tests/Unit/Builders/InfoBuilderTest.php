<?php

namespace Tests\Unit\Builders;

use MohammadAlavi\LaravelOpenApi\Collectors\InfoBuilder;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

#[CoversClass(InfoBuilder::class)]
class InfoBuilderTest extends TestCase
{
    public static function providerBuildContact(): \Iterator
    {
        $common = [
            'title' => 'sample_title',
            'description' => 'sample_description',
            'version' => 'sample_version',
        ];
        yield 'If all the elements are present, the correct json can be output.' => [
            [...$common, 'contact' => [
                'name' => 'sample_contact_name',
                'email' => 'sample_contact_email',
                'url' => 'sample_contact_url',
            ], 'license' => [
                'name' => 'sample_license_name',
                'url' => 'sample_license_url',
            ]],
            [...$common, 'contact' => [
                'name' => 'sample_contact_name',
                'email' => 'sample_contact_email',
                'url' => 'sample_contact_url',
            ], 'license' => [
                'name' => 'sample_license_name',
                'url' => 'sample_license_url',
            ]],
        ];
        yield 'If Contact.name does not exist, the correct json can be output.' => [
            [...$common, 'contact' => [
                'email' => 'sample_contact_email',
                'url' => 'sample_contact_url',
            ], 'license' => [
                'name' => 'sample_license_name',
                'url' => 'sample_license_url',
            ]],
            [...$common, 'contact' => [
                'email' => 'sample_contact_email',
                'url' => 'sample_contact_url',
            ], 'license' => [
                'name' => 'sample_license_name',
                'url' => 'sample_license_url',
            ]],
        ];
        yield 'If Contact.email does not exist, the correct json can be output.' => [
            [...$common, 'contact' => [
                'name' => 'sample_contact_name',
                'url' => 'sample_contact_url',
            ], 'license' => [
                'name' => 'sample_license_name',
                'url' => 'sample_license_url',
            ]],
            [...$common, 'contact' => [
                'name' => 'sample_contact_name',
                'url' => 'sample_contact_url',
            ], 'license' => [
                'name' => 'sample_license_name',
                'url' => 'sample_license_url',
            ]],
        ];
        yield 'If Contact.url does not exist, the correct json can be output.' => [
            [...$common, 'contact' => [
                'name' => 'sample_contact_name',
                'email' => 'sample_contact_email',
            ], 'license' => [
                'name' => 'sample_license_name',
                'url' => 'sample_license_url',
            ]],
            [...$common, 'contact' => [
                'name' => 'sample_contact_name',
                'email' => 'sample_contact_email',
            ], 'license' => [
                'name' => 'sample_license_name',
                'url' => 'sample_license_url',
            ]],
        ];
        yield 'If Contact does not exist, the correct json can be output.' => [
            [...$common, 'license' => [
                'name' => 'sample_license_name',
                'url' => 'sample_license_url',
            ]],
            [...$common, 'license' => [
                'name' => 'sample_license_name',
                'url' => 'sample_license_url',
            ]],
        ];
        yield 'If Contact.* does not exist, the correct json can be output.' => [
            [...$common, 'contact' => [], 'license' => [
                'name' => 'sample_license_name',
                'url' => 'sample_license_url',
            ]],
            [...$common, 'license' => [
                'name' => 'sample_license_name',
                'url' => 'sample_license_url',
            ]],
        ];
        yield 'If License.name does not exist, the correct json can be output.' => [
            [...$common, 'contact' => [
                'name' => 'sample_contact_name',
                'email' => 'sample_contact_email',
                'url' => 'sample_contact_url',
            ], 'license' => [
                'url' => 'sample_license_url',
            ]],
            [...$common, 'contact' => [
                'name' => 'sample_contact_name',
                'email' => 'sample_contact_email',
                'url' => 'sample_contact_url',
            ]],
        ];
        yield 'If License.url does not exist, the correct json can be output.' => [
            [...$common, 'contact' => [
                'name' => 'sample_contact_name',
                'email' => 'sample_contact_email',
                'url' => 'sample_contact_url',
            ], 'license' => [
                'name' => 'sample_license_name',
            ]],
            [...$common, 'contact' => [
                'name' => 'sample_contact_name',
                'email' => 'sample_contact_email',
                'url' => 'sample_contact_url',
            ], 'license' => [
                'name' => 'sample_license_name',
            ]],
        ];
        yield 'If License does not exist, the correct json can be output.' => [
            [...$common, 'contact' => [
                'name' => 'sample_contact_name',
                'email' => 'sample_contact_email',
                'url' => 'sample_contact_url',
            ]],
            [...$common, 'contact' => [
                'name' => 'sample_contact_name',
                'email' => 'sample_contact_email',
                'url' => 'sample_contact_url',
            ]],
        ];
        yield 'If License.* does not exist, the correct json can be output.' => [
            [...$common, 'contact' => [
                'name' => 'sample_contact_name',
                'email' => 'sample_contact_email',
                'url' => 'sample_contact_url',
            ], 'license' => []],
            [...$common, 'contact' => [
                'name' => 'sample_contact_name',
                'email' => 'sample_contact_email',
                'url' => 'sample_contact_url',
            ]],
        ];
        yield 'If License and Contacts do not exist, the correct json can be output.' => [
            $common,
            $common,
        ];
    }

    #[DataProvider('providerBuildContact')]
    public function testBuildContact(array $config, array $expected): void
    {
        $infoBuilder = new InfoBuilder();
        $info = $infoBuilder->build($config);
        $this->assertSameAssociativeArray($expected, $info->toArray());
    }

    /**
     * Assert equality as an associative array.
     */
    protected function assertSameAssociativeArray(array $expected, array $actual): void
    {
        foreach ($expected as $key => $value) {
            if (is_array($value)) {
                $this->assertSameAssociativeArray($value, $actual[$key]);
                unset($actual[$key]);
                continue;
            }

            $this->assertSame($value, $actual[$key]);
            unset($actual[$key]);
        }

        $this->assertCount(0, $actual, sprintf('[%s] does not matched keys.', implode(', ', array_keys($actual))));
    }
}
