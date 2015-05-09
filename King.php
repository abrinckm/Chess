<?php
require_once( "ChessPiece.php" );

class King extends ChessPiece
{
	//------------------------------------------------------------------
	public function __construct( $color, $startingSquare )
	{
		parent::__construct( "King", 				//name
							 $color,				
							 $startingSquare,
							 array( 				//legal moves 
								new Move( 1, 0 ),	//(# of spaces)
								new Move( 0, 1 ),
								new Move( 1, 1 )
							 ),						
							 array( 				//legal attack moves 
								new Move( 1, 0 ),	//(# of spaces)
								new Move( 0, 1 ),
								new Move( 1, 1 )
							 ),
							 99						//starting value		  
							);
	}
	//------------------------------------------------------------------
	protected function isLegalMove( $move )
	{
		foreach( $this->legalMoves as $legalMove )
		{
			if( $legalMove->isEqualSpaces( $move ) )
			{
				return true;
			}
		}
		return false;
	}
	//------------------------------------------------------------------
	protected function isLegalAttack( $move )
	{
		foreach( $this->legalAttacks as $legalAttack )
		{
			if( $legalAttack->isEqualSpaces( $move ) )
			{
				return true;
			}
		}
		return false;
	}
} //King
?>