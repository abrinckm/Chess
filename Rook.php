<?php
require_once( "ChessPiece.php" );

class Rook extends ChessPiece
{
	//------------------------------------------------------------------
	public function __construct( $color, $startingSquare )
	{
		parent::__construct( "Rook", 				//name
							 $color,				
							 $startingSquare,
							 array( 				//legal moves 
								new Move( 1, 0 ),	//(X:Y ratio)
								new Move( 0, 1 )
							 ),						
							 array( 				//legal attack moves 
								new Move( 1, 0 ),	//(X:Y ratio)
								new Move( 0, 1 )
							 ),
							 5.1					//starting value			  
							);	
	}
	//------------------------------------------------------------------
	protected function isLegalMove( $move )
	{
		foreach( $this->legalMoves as $legalMove )
		{
			if( $legalMove->isEqualRatio( $move ) )
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
			if( $legalAttack->isEqualRatio( $move ) )
			{
				return true;
			}
		}
		return false;
	}
} //Rook

?>