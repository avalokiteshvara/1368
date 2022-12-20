<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// To disable Minifyhtml,simply change COMPRESS_OUTPUT to FALSE.
if ( ! defined('COMPRESS_OUTPUT'))
{
	define('COMPRESS_OUTPUT', FALSE);
}


/**
 * Minifyhtml Class
 * Will Minify the HTML. Reducing network latency, enhancing compression, and faster browser loading and execution.
 * 
 * @category	Output
 * @author      John Gerome
 * @link	    https://github.com/johngerome/CodeIgniter-Minifyhtml-hooks
 */
 
class Minifyhtml {
    
    /**
     * Responsible for sending final output to browser
     */
    function output()
    {   
        $CI =& get_instance();
        $buffer = $CI->output->get_output();
        $re = '%            # Collapse ws everywhere but in blacklisted elements.
            (?>             # Match all whitespans other than single space.
              [^\S ]\s*     # Either one [\t\r\n\f\v] and zero or more ws,
            | \s{2,}        # or two or more consecutive-any-whitespace.
            ) # Note: The remaining regex consumes no text at all...
            (?=             # Ensure we are not in a blacklist tag.
              (?:           # Begin (unnecessary) group.
                (?:         # Zero or more of...
                  [^<]++    # Either one or more non-"<"
                | <         # or a < starting a non-blacklist tag.
                  (?!/?(?:textarea|pre)\b)
                )*+         # (This could be "unroll-the-loop"ified.)
              )             # End (unnecessary) group.
              (?:           # Begin alternation group.
                <           # Either a blacklist start tag.
                (?>textarea|pre)\b
              | \z          # or end of file.
              )             # End alternation group.
            )  # If we made it here, we are not in a blacklist tag.
            %ix';
        
		if (COMPRESS_OUTPUT)
		{
            $buffer = preg_replace($re, " ", $buffer);		
		}    
        
        $CI->output->set_output($buffer);
        $CI->output->_display();
    }
}
?>