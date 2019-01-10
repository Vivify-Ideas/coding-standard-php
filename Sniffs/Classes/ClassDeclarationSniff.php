<?php

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class Vivify_Sniffs_Classes_ClassDeclarationSniff implements Sniff
{

    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(
            T_CLASS,
            T_INTERFACE,
            T_TRAIT,
        );

    }//end register()


    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param integer $stackPtr The position of the current token in the
     *                                        stack passed in $tokens.
     *
     * @return void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $errorData = array(strtolower($tokens[$stackPtr]['content']));

        $curlyBrace = $tokens[$stackPtr]['scope_opener'];
        $characterBeforeBrace = $tokens[$curlyBrace - 1]['type'];
        $lastContent = $phpcsFile->findPrevious(T_WHITESPACE, ($curlyBrace - 1), $stackPtr, true);
        $classLine = $tokens[$lastContent]['line'];
        $braceLine = $tokens[$curlyBrace]['line'];
        if ($braceLine !== $classLine || $characterBeforeBrace !== 'T_WHITESPACE') {
            $phpcsFile->recordMetric($stackPtr, 'Class opening brace placement', 'new line');
            $error = 'Opening brace of a %s must be on the same line as definition and there should be space between definition and bracket';
            $phpcsFile->addWarning($error, $stackPtr, 'OpenBraceNewLine', $errorData);

            return;
        }//end if

    }//end process()
}//end class
