<?php

use PHP_CodeSniffer\Sniffs\AbstractScopeSniff;
use PHP_CodeSniffer\Util\Tokens;
use PHP_CodeSniffer\Files\File;

class Vivify_Sniffs_Methods_MethodDeclarationSniff extends AbstractScopeSniff {

    public function __construct()
    {
        parent::__construct(array(T_CLASS, T_INTERFACE), array(T_FUNCTION));

    }//end __construct()


    /**
     * Processes the function tokens within the class.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file where this token was found.
     * @param int $stackPtr The position where the token was found.
     * @param int $currScope The current scope opener token.
     *
     * @return void
     */
    protected function processTokenWithinScope(
        File $phpcsFile,
        $stackPtr,
        $currScope
    ) {
        $tokens = $phpcsFile->getTokens();

        $methodProperties = $phpcsFile->getMethodProperties($stackPtr);
        $methodName = $phpcsFile->getDeclarationName($stackPtr);
        if ($methodName === null) {
            // Ignore closures.
            return;
        }
        if (
            $methodProperties['scope_specified'] &&
            $methodProperties['scope'] === 'private' &&
            $methodName[0] !== '_' &&
            isset($methodName[1]) === true &&
            $methodName[1] !== '_'
        ) {
            $error = 'Method name "%s" should be prefixed with an underscore to indicate private visibility';
            $data = array($methodName);
            $phpcsFile->addWarning($error, $stackPtr, 'Underscore', $data);
        }
    }

    protected function processTokenOutsideScope(File $phpcsFile, $stackPtr)
    {
    }//end processTokenOutsideScope()

}//end class
