<?php

use PHP_CodeSniffer\Sniffs\AbstractVariableSniff;
use PHP_CodeSniffer\Files\File;

class Vivify_Sniffs_Classes_PropertyDeclarationSniff extends AbstractVariableSniff
{
    /**
     * Processes the function tokens within the class.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file where this token was found.
     * @param int                         $stackPtr  The position where the token was found.
     *
     * @return void
     */
    protected function processMemberVar(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        try {
            $propertyInfo = $phpcsFile->getMemberProperties($stackPtr);
            if (empty($propertyInfo) === true) {
                return;
            }
        } catch (\Exception $e) {
            // Turns out not to be a property after all.
            return;
        }

        if ($propertyInfo['scope_specified'] === true && $propertyInfo['scope'] === 'private') {
            if ($tokens[$stackPtr]['content'][1] !== '_') {
                $error = 'Private property name "%s" should be prefixed with an underscore to indicate visibility';
                $data  = [$tokens[$stackPtr]['content']];
                $phpcsFile->addWarning($error, $stackPtr, 'Underscore', $data);
            }
        }
    }//end processMemberVar()


    /**
     * Processes normal variables.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file where this token was found.
     * @param int                         $stackPtr  The position where the token was found.
     *
     * @return void
     */
    protected function processVariable(File $phpcsFile, $stackPtr)
    {
        /*
            We don't care about normal variables.
        */

    }//end processVariable()


    /**
     * Processes variables in double quoted strings.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file where this token was found.
     * @param int                         $stackPtr  The position where the token was found.
     *
     * @return void
     */
    protected function processVariableInString(File $phpcsFile, $stackPtr)
    {
        /*
            We don't care about normal variables.
        */

    }//end processVariableInString()
}//end class