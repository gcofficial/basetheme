<?php
/**
 * Core ICompiler interface file
 *
 * @package photolab
 */

namespace View;

/**
 * ICompiler interfac
 */
interface ICompiler {

	/**
	 * Compile the view at the given path.
	 *
	 * @param type $path compile path.
	 * @return void
	 */
	public function compile( $path );
}
