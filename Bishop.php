<?php
require_once( "ChessPiece.php" );

class Bishop extends ChessPiece
{
	//------------------------------------------------------------------
	public function __construct( $color, $startingSquare )
	{
		parent::__construct( "Bishop", 				//name
							 $color,				
							 $startingSquare,
							 array( 				//legal moves 
								new Move( 1, 1 )	//(X:Y ratio)
							 ),						
							 array( 				//legal attack moves 
								new Move( 1, 1 )	//(X:Y ratio)
							 ),
							 3.33					//starting value			  
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
} //Bishop

?>