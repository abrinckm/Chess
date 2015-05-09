<?php
require_once( "ChessPiece.php" );

class Queen extends ChessPiece
{
	//------------------------------------------------------------------
	public function __construct( $color, $startingSquare )
	{
		parent::__construct( "Queen", 				//name
							 $color,				
							 $startingSquare,
							 array( 				//legal moves 
								new Move( 1, 0 ),	//(X:Y ratio)
								new Move( 0, 1 ),
								new Move( 1, 1 )
							 ),						
							 array( 				//legal attack moves 
								new Move( 1, 0 ),	//(X:Y ratio)
								new Move( 0, 1 ),
								new Move( 1, 1 )
							 ),
							 8.8					//starting value			  
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
} //Queen

?>