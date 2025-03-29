<?php
/**
 * Diff API: NX_Text_Diff_Renderer_Table class
 *
 * @package NexusPress
 * @subpackage Diff
 * @since 4.7.0
 */

/**
 * Table renderer to display the diff lines.
 *
 * @since 2.6.0
 * @uses Text_Diff_Renderer Extends
 */
class NX_Text_Diff_Renderer_Table extends Text_Diff_Renderer {
    /**
     * @see Text_Diff_Renderer::_startBlock()
     *
     * @since 2.6.0
     *
     * @param int $header The header to output.
     * @return string The table row for the start of a diff block.
     */
    protected function _startBlock( $header ) {
        return "<tr><td class='diff-blockheader'>$header</td></tr>\n";
    }

    /**
     * @see Text_Diff_Renderer::_endBlock()
     *
     * @since 2.6.0
     *
     * @return string The table row for the end of a diff block.
     */
    protected function _endBlock() {
        return "</tr>\n";
    }

    /**
     * @see Text_Diff_Renderer::_lines()
     *
     * @since 2.6.0
     *
     * @param array $lines Array of lines to render.
     * @param string $prefix Line prefix.
     * @param string $color CSS class to use for the table cell.
     * @return string The table row for the lines.
     */
    protected function _lines( $lines, $prefix = ' ', $color = 'white' ) {
        $r = '';
        foreach ( $lines as $line ) {
            $r .= "<tr><td class='diff-context'>$line</td></tr>\n";
        }
        return $r;
    }

    /**
     * @see Text_Diff_Renderer::_added()
     *
     * @since 2.6.0
     *
     * @param array $lines Array of lines.
     * @return string The table row for added lines.
     */
    protected function _added( $lines ) {
        $r = '';
        foreach ( $lines as $line ) {
            $r .= "<tr><td class='diff-addedline'>+ $line</td></tr>\n";
        }
        return $r;
    }

    /**
     * @see Text_Diff_Renderer::_deleted()
     *
     * @since 2.6.0
     *
     * @param array $lines Array of lines.
     * @return string The table row for deleted lines.
     */
    protected function _deleted( $lines ) {
        $r = '';
        foreach ( $lines as $line ) {
            $r .= "<tr><td class='diff-deletedline'>- $line</td></tr>\n";
        }
        return $r;
    }

    /**
     * @see Text_Diff_Renderer::_changed()
     *
     * @since 2.6.0
     *
     * @param array $orig Original lines.
     * @param array $final New lines.
     * @return string The table row for changed lines.
     */
    protected function _changed( $orig, $final ) {
        $r = '';

        // Inline diffs.
        $diff = new Text_Diff( 'auto', array( array( $orig ), array( $final ) ) );
        $renderer = new NX_Text_Diff_Renderer_inline();
        $text = $renderer->render( $diff );

        $text = preg_replace( '!\s+!', ' ', $text );
        $text = trim( $text );

        if ( ! $text ) {
            return '';
        }

        $lines = explode( "\n", $text );

        foreach ( $lines as $line ) {
            $r .= "<tr><td class='diff-context'>$line</td></tr>\n";
        }

        return $r;
    }

    /**
     * Generates a string representation of the changes.
     *
     * @since 2.6.0
     *
     * @param Text_Diff $diff Text_Diff object.
     * @return string Table showing the diff with changes highlighted.
     */
    public function render( $diff ) {
        $this->diff = $diff;

        $output = "<table class='diff'>\n";

        foreach ( $diff->get_diff() as $block ) {
            $output .= $this->_block( $block );
        }

        $output .= "</table>\n";

        return $output;
    }
} 