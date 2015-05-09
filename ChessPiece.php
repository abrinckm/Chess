<?php
include( "Move.php");

abstract class ChessPiece
{
	private $iconURL;
	private $legalMoves;
	private $legalAttacks;
	private $cost;
	private $name;
	private $currentSquare;
	private $color;
	private $numberOfMoves;
	//------------------------------------------------------------------
	public function __construct( $name, 
								 $color,
								 $startingSquare,
								 $legalMoves,
								 $legalAttacks,
								 $cost						  
								)
	{
		$this->iconURL = "url(" . $color . $name . ".png)";
		$this->legalMoves = $legalMoves;
		$this->legalAttacks = $legalAttacks;
		$this->cost = $cost;
		$this->name = $name;
		$this->currentSquare = $startingSquare;
		$this->color = $color;
	}
	//------------------------------------------------------------------
	public function __get( $field )
	{
		if( property_exists( __CLASS__, $field ) )
		{
			return $this->$field;
		}
		return false;
	}
	//------------------------------------------------------------------
	public function moveToSquare( $square )
	{
		$currentSquare = $this->currentSquare;
		$diffX = $square[0] - $currentSquare[0];
		$diffY = $square[1] - $currentSquare[1];
		$move = new Move( $diffX, $diffY );
		if( $this->isLegalMove( $move ) )
		{
			$this->currentSquare = $square;
			$this->numberOfMoves++;
			return true;
		}
		return false;
	}
	//------------------------------------------------------------------
	public function attackSquare( $square )
	{
		$currentSquare = $this->currentSquare;
		$diffX = abs( $square[0] - $currentSquare[0] );
		$diffY = abs( $square[1] - $currentSquare[1] );
		$move = new Move( $diffX, $diffY );
		if( $this->isLegalAttack( $move ) )
		{
			$this->currentSquare = $square;
			return true;
		}
		return false;
	}
	//------------------------------------------------------------------
	abstract protected function isLegalMove( $move );
	//------------------------------------------------------------------
	abstract protected function isLegalAttack( $move );
} //ChessPiece
//----------------------------------------------------------------------



?>