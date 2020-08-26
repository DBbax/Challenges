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
    

    public function test_can_change_dir__from_path__to_path()
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

    public function test_cannot_be_created__with_empty_param(): void
    {
        $this->expectException(Exception::class);
        $path = new Path('');
    }

    public function test_cannot_be_created__without_initial_rootpath(): void
    {
        $this->expectException(Exception::class);
        $path = new Path('a/b/');
    }

    public function test_cannot_be_created__with_two_dots(): void
    {
        $this->expectException(Exception::class);
        $path = new Path('..');
    }

    public function test_cannot_be_created__with_three_or_more_dots(): void
    {
        $this->expectException(Exception::class);
        $path = new Path('...');
    }

    public function test_cannot_be_created__with_two_dots_in_path(): void
    {
        $this->expectException(Exception::class);
        $path = new Path('/a/../b');
    }

    public function test_cannot_be_created__with_dot_in_folder_name(): void
    {
        $this->expectException(Exception::class);
        $path = new Path('/a/b/.c');
    }

    public function test_cannot_be_created__with_number_chars(): void
    {
        $this->expectException(Exception::class);
        $path = new Path('/a/123');
    }

    public function test_cannot_be_created__with_other_chars(): void
    {
        $this->expectException(Exception::class);
        $path = new Path('/a/$%&');
    }

    public function test_cannot_change_dir__with_three_or_more_dots_in_path(): void
    {
        $this->expectException(Exception::class);
        $path = new Path('/a/.../b');
    }

    // - - - - - - - - - - - - - - - - - - - - - - - -


    

}
