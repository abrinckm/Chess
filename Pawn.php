<?php
require_once( "ChessPiece.php" );

class Pawn extends ChessPiece
{
	//------------------------------------------------------------------
	public function __construct( $color, $startingSquare )
	{
		if( $color == "White" )
		{
			$legalMoves = array( 
				new Move( 0, 1 )		//Exact movement
			);
			$legalAttacks = array(
				new Move( 1, 1 ),
				new Move( -1, 1 )
			);
		}
		else
		{
			$legalMoves = array( 
				new Move( 0, -1 )
			);
			$legalAttacks = array(
				new Move( 1, -1 ),		//Exact movements
				new Move( -1, -1 )
			);
		}
		parent::__construct( "Pawn", 				//name
							 $color,				
							 $startingSquare,
							 $legalMoves,						
							 $legalAttacks,
							 1						//starting value			  
							);	
	}
	//------------------------------------------------------------------
	protected function isLegalMove( $move )
	{
		if( $this->numberOfMoves == 0 && 
			$move->isEqualSpaces( new Move( 0, 2 ) ) )
		{
			return true;
		}
		foreach( $this->legalMoves as $legalMove )
		{
			if( $legalMove->isEqualMove( $move ) )
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
			if( $legalAttack->isEqualMove( $move ) )
			{
				return true;
			}
		}
		return false;
	}
} //Pawn

?>