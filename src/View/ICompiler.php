<?php
namespace View;

interface ICompiler {

    /**
     * Compile the view at the given path.
     *
     * @param string $path
     * @return void
     */
    public function compile($path);

} 