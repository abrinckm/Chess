<?php
include( "Pawn.php" );
include( "Knight.php" );
include( "Bishop.php" );
include( "Rook.php" );
include( "King.php" );
include( "Queen.php" );

class GameBoard
{
	private $files;
	private $ranks;
	private $square;
	private $selectedSquare;
	private $player1;
	private $player2;
	private $turn; 
	//------------------------------------------------------------------
	public function __construct( $player1,
								 $player2,
								 $ranks = 8, 
								 $files = 8 )
	{
		$this->player1 = $player1;
		$this->player2 = $player2;
		$this->ranks = $ranks;
		$this->files = $files;
		$this->clearBoard( );
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
	public function attackPiece( )
	{
		return false;
	}
	//------------------------------------------------------------------
	public function clearBoard( )
	{
		for( $X = 1; $X <= $this->files; $X++ )
		{
			for( $Y = 1; $Y <= $this->ranks; $Y++ )
			{
				$this->square[$X][$Y] = "";
			}
		}
	}
	//------------------------------------------------------------------
	public function drawBoard( $perspective )
	{
		if( $perspective == $this->player1 )
		{
			$topRank = $this->ranks * -1;
			$bottomRank = -1;
		}
		else
		{
			$topRank = 1;
			$bottomRank = $this->ranks;
		}
		$light = "#eec";
		$dark = "#775";
		$tile = $light;
		$HTML = "<table style='background:#555;z-index:-1;'>";
		for( $Y = $topRank; $Y <= $bottomRank; $Y++ )
		{
			$HTML .= "
				<tr style='z-index:-1'>";
			for( $X = 1; $X <= $this->files; $X++ )
			{
				$piece = $this->square[$X][abs( $Y )];
				$drawPiece = ( $piece == "" ) ? "" : $piece->iconURL;		
				$HTML .= "
						<td style='background:{$tile};z-index:-1;'>
								<div style='width:64px;
											height:64px;
											background:{$drawPiece};
											display:block;
											z-index:20;'
									 onclick='select( this );'
									 X='$X'
									 Y='" . abs( $Y ) . "'></div>
						</td>";
				$tile = ( $tile == $dark ) ? $light : $dark;
			}
			$HTML .= "
				</tr>";
			$tile = ( $tile == $dark ) ? $light : $dark;
		}
		$HTML .= "</table>";
		echo( $HTML );
	}
	//------------------------------------------------------------------
	public function isEmptySquare( $square )
	{
		$X = $square[0];
		$Y = $square[1];
		if( $this->square[$X][$Y] == "" )
		{
			return true;
		}
		return false;
	}
	//------------------------------------------------------------------
	public function isLegalSquare( $square )
	{
		$X = $square[0];
		$Y = $square[1];
		if( ( $X < 1 || $X > $this->files ) ||
			( $Y < 1 || $Y > $this->ranks ) )
		{
			return false;
		}
		return true;
	}
	//------------------------------------------------------------------
	public function isObstructed( $fromSquare, $toSquare )
	{
		$X = $fromSquare[0];
		$Y = $fromSquare[1];
		$toX = $toSquare[0];
		$toY = $toSquare[1];
		$nextX = ($X < $toX ) ? 1 : -1;
		$nextY = ($Y < $toY ) ? 1 : -1;
		while( $X != $toX || $Y != $toY )
		{
			$X = ( $X != $toX ) ? $X += $nextX : $X;
			$Y = ( $Y != $toY ) ? $Y += $nextY : $Y;
			if( $X != $toX || $Y != $toY )
			{
				if( $this->square[$X][$Y] != "" )
				{
					return true;
				}
			}
		}
		return false;
	}
	//------------------------------------------------------------------
	public function isPlayerPiece( $square )
	{
		$X = $square[0];
		$Y = $square[1];
		if( $this->square[$X][$Y] == "" )
		{
			return false;
		}
		$color = $this->square[$X][$Y]->color;
		$turn = $this->turn;
		if( $color == "White" && $turn == $this->player1 )
		{
			return true;
		}
		else if( $color == "Black" && $turn == $this->player2 )
		{
			return true;
		}
		return false;
	}
	//------------------------------------------------------------------
	public function movePiece( $fromSquare, $toSquare )
	{
		$fromX = $fromSquare[0];
		$fromY = $fromSquare[1];
		$toX = $toSquare[0];
		$toY = $toSquare[1];
		if( $this->square[$fromX][$fromY]->name != "Knight" &&
			$this->isObstructed( $fromSquare, $toSquare ) )
		{
			return false;
		}
		if( $this->square[$fromX][$fromY]->moveToSquare( $toSquare ) == true )
		{
			$this->square[$toX][$toY] = $this->square[$fromX][$fromY];
			$this->square[$fromX][$fromY] = "";
			return true;
		}
		return false;
	}
	//------------------------------------------------------------------
	public function saveState( )
	{
	}
	//------------------------------------------------------------------
	public function setupChess( )
	{
		$this->ranks = 8;
		$this->files = 8;
		$this->clearBoard( );
		$this->turn = $this->player1;
		//Setup pawns on 2nd and 7th ranks
		for( $Y = 2; $Y <= 7; $Y += 5 )
		{
			$color = ( $Y == 2 ) ? "White" : "Black";
			for( $X = 1; $X <= 8; $X++ )
			{
				$this->square[$X][$Y] = new Pawn( $color, array( $X, $Y ) );
			}
		}
		//Setup pieces on 1st and 8th ranks
		for( $Y = 1; $Y <= 8; $Y += 7 )
		{
			$color = ( $Y == 1 ) ? "White" : "Black";
			$this->square[1][$Y] = new Rook( $color, array( 1, $Y ) );
			$this->square[2][$Y] = new Knight( $color, array( 2, $Y ) );
			$this->square[3][$Y] = new Bishop( $color, array( 3, $Y ) );
			$this->square[4][$Y] = new Queen( $color, array( 4, $Y ) );
			$this->square[5][$Y] = new King( $color, array( 5, $Y ) );
			$this->square[6][$Y] = new Bishop( $color, array( 6, $Y ) );
			$this->square[7][$Y] = new Knight( $color, array( 7, $Y ) );
			$this->square[8][$Y] = new Rook( $color, array( 8, $Y ) );
		}
	}
} //GameBoard
?>