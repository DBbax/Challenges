<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class PathTest extends TestCase
{
    // - - - - - - - - - - - - - - - - - - - - - - - -
    // CAN DO

    public function test_can_be_created__with_no_param()
    {
        $path = new Path();
        $this->assertInstanceOf(Path::class, $path);
    }

    public function test_can_be_created__with_paths()
    {
        $paths = [
            '/',
            '/a',
            '/a/',
            '/a/b',
            '/a/b/',
            '/a/b/c/d',
            '/A',
            '/A/b',
            '/A/B/c',
            '/A/B/c/D',
        ];

        foreach($paths as $path)
        {
            $path = new Path($path);
            $this->assertInstanceOf(Path::class, $path);
        }
    }
    

    public function test_can_change_dir__with_paths()
    {
        
        $change_dir__current_path = [
            '..' => '/a/b/c',
            '../' => '/a/b/c',
            '../x' => '/a/b/c/x',
            '../../../..' => '/',
            '../../../../..' => '/',
            '/' => '/',
            '/a' => '/a',
            '/A' => '/A',
            '/a/B/..' => '/a',
            '/a/B/../c' => '/a/c',
        ];

        foreach($change_dir__current_path as $change_dir => $current_path)
        {
            $path = new Path('/a/b/c/d');
            $path->cd($change_dir);
            $this->assertEquals($current_path, $path->currentPath);
        }
    }


    // - - - - - - - - - - - - - - - - - - - - - - - -
    // CAN'T DO

    public function test_cannot_be_created__with_paths(): void
    {
        $paths = [
            '',
            'a',
            'a/',
            'a/b',
            '.',
            '..',
            '../',
            '...',
            '/a.',
            '/a/..',
            '/a/../b',
            '/a/.../b',
            '/a/.b',
            '/a/b.',
            '/a/.b.',
            '/a/../',
            '/a1',
            '/a/123',
            '/<?',
            '/234',
        ];

        foreach($paths as $path)
        {
            $this->expectException(Exception::class);
            $path = new Path($path);
        }
    }


    public function test_cannot_change_dir__with_paths()
    {
        
        $change_dir__current_path = [
            '',
            '.',
            '...',
            '/a.',
            '/a/.../b',
            '/a/.b',
            '/a/b.',
            '/a/.b.',
            '/a1',
            '/a/123',
            '/<?',
            '/234',
        ];

        foreach($change_dir__current_path as $change_dir => $current_path)
        {
            $this->expectException(Exception::class);
            $path = new Path('/a/b/c/d');
            $path->cd($change_dir);
        }
    }


    // - - - - - - - - - - - - - - - - - - - - - - - -


    

}
