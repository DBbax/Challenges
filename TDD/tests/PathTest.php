<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class PathTest extends TestCase
{
    // - - - - - - - - - - - - - - - - - - - - - - - -
    // CAN DO

    public function test_can_be_created__with_no_param(): void
    {
        $path = new Path();
        $this->assertInstanceOf(Path::class, $path);
    }

    public function test_can_be_created__with_only_rootpath(): void
    {
        $path = new Path('/');
        $this->assertInstanceOf(Path::class, $path);
    }

    public function test_can_be_created__with_one_folder(): void
    {
        $path = new Path('/a');
        $this->assertInstanceOf(Path::class, $path);
    }

    public function test_can_be_created__with_multiple_folders(): void
    {
        $path = new Path('/a/b/c/d');
        $this->assertInstanceOf(Path::class, $path);
    }

    public function test_can_change_dir__to_parent()
    {
        $path = new Path('/a/b/c/d');
        $path->cd('..');
        $this->assertEquals('/a/b/c', $path->currentPath);
    }

    public function test_can_change_dir__to_parent_and_another_child()
    {
        $path = new Path('/a/b/c/d');
        $path->cd('../x');
        $this->assertEquals('/a/b/c/x', $path->currentPath);
    }

    public function test_can_change_dir__to_root_parent()
    {
        $path = new Path('/a/b/c/d');
        $path->cd('../../../..');
        $this->assertEquals('/', $path->currentPath);
    }

    public function test_can_change_dir__to_root_parent_with_extra_parent_change()
    {
        $path = new Path('/a/b/c/d');
        $path->cd('../../../../../../../../');
        $this->assertEquals('/', $path->currentPath);
    }

    public function test_can_change_dir__to_root_directly()
    {
        $path = new Path('/a/b/c/d');
        $path->cd('/');
        $this->assertEquals('/', $path->currentPath);
    }

    public function test_can_change_dir__to_other_path_directly()
    {
        $path = new Path('/a/b/c/d');
        $path->cd('/x/f');
        $this->assertEquals('/x/f', $path->currentPath);
    }

    // - - - - - - - - - - - - - - - - - - - - - - - -
    // CAN'T DO

    public function test_cannot_be_created_with_empty_param(): void
    {
        $this->expectException(Exception::class);
        $path = new Path('');
    }

    public function test_cannot_be_created_without_initial_rootpath(): void
    {
        $this->expectException(Exception::class);
        $path = new Path('a/b/');
    }

    public function test_cannot_be_created_with_two_dots(): void
    {
        $this->expectException(Exception::class);
        $path = new Path('..');
    }

    public function test_cannot_be_created_with_two_dots_in_path(): void
    {
        $this->expectException(Exception::class);
        $path = new Path('/a/../b');
    }

    // - - - - - - - - - - - - - - - - - - - - - - - -


    

}
