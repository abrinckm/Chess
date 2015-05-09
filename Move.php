<?php

class Move
{
	private $X;
	private $Y;
	//------------------------------------------------------------------
	public function __construct( $X, $Y )
	{
		$this->X = $X;
		$this->Y = $Y;
	}
	//------------------------------------------------------------------
	public function get( $field )
	{
		if( property_exists( __CLASS__, $field ) )
		{
			return $this->$field;
		}
		return false;
	}
	//------------------------------------------------------------------
	public function isEqualSpaces( $move )
	{
		if( !( $move instanceof Move ) )
		{
			return false;
		}
		if( abs( $this->X ) == abs( $move->X ) && 
			abs( $this->Y ) == abs( $move->Y ) )
		{
			return true;
		}
		return false;
	}
	//------------------------------------------------------------------
	public function isEqualMove( $move )
	{
		if( !( $move instanceof Move ) )
		{
			return false;
		}
		if( $this->X == $move->X && 
			$this->Y == $move->Y )
		{
			return true;
		}
		return false;
	}
	//------------------------------------------------------------------
	public function isEqualRatio( $move )
	{
		if( !( $move instanceof Move ) )
		{
			return false;
		}
		$move = $this->reduce( $move );
		return( $this->reduce( $this )->isEqualSpaces( $move ) );
	}
	//------------------------------------------------------------------
	private function reduce( $move )
	{
		$GCD = $this->GCD( $move->X, $move->Y );
		return new Move( ( $move->X / $GCD ), 
						 ( $move->Y / $GCD ) );
	}
	//------------------------------------------------------------------
	private function GCD( $a, $b ) 
	{ 
		if( $b == 0 ) 
		{ 
			return $a; 
		} 
		else 
		{ 
			return $this->GCD( $b, $a % $b ); 
		} 
	} 
} //move

?>