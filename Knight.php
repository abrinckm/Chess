<?php
require_once( "ChessPiece.php" );

class Knight extends ChessPiece
{
	//------------------------------------------------------------------
	public function __construct( $color, $startingSquare )
	{
		parent::__construct( "Knight", 				//name
							 $color,				//color
							 $startingSquare,
							 array( 
								new Move( 1, 2 ),	//legal moves
								new Move( 2, 1 )	//(# of spaces)
							 ),
							  array( 
								new Move( 1, 2 ),	//legal attack moves
								new Move( 2, 1 )	//(# of spaces)
							 ),
							 3.2					//starting value			  
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
} //Knight

?>