<?php
session_start( );
include( "GameBoard.php" );

$response = array( "good"=>true, "error"=>"" );
$action = $_GET['action'];
switch( $action )
{
	case "movePiece":
		$fromSquare = json_decode( $_GET['fromSquare'] );
		$toSquare = json_decode( $_GET['toSquare'] );
		$gameBoard = unserialize( $_SESSION['GameBoard'] );
		if( $gameBoard->isPlayerPiece( $toSquare ) )
		{
			$response["good"] = false;
			$response["error"] = "This square is occupied by another player controlled piece.";
		}
		else if( $gameBoard->isEmptySquare( $toSquare ) )
		{
			if( !$gameBoard->movePiece( $fromSquare, $toSquare ) )
			{
				$response["good"] = false;
				$response["error"] = "Illegal move.";
			}
		}
		else
		{
			if( !$gameBoard->attackPiece( $fromSquare, $toSquare ) )
			{
				$response["good"] = false;
				$response["error"] = "Illegal attack.";
			}
		}
		$_SESSION['GameBoard'] = serialize( $gameBoard );
		echo( json_encode( $response ) );
		break;
	case "startChessGame":
		$player1 = 'Adam';
		$player2 = 'April';
		$chessBoard = new GameBoard( $player1, $player2 );
		$chessBoard->setupChess( );
		$_SESSION['GameBoard'] = serialize( $chessBoard );
		echo $chessBoard->drawBoard( $player1 );
		break;
	case "selectPiece":
		$square = json_decode( $_GET['square'] );
		$gameBoard = unserialize( $_SESSION['GameBoard'] );
		if( $gameBoard->isEmptySquare( $square ) )
		{
			$response["good"] = false;
			$response["error"] = "Empty square.";
		}
		else if( !$gameBoard->isPlayerPiece( $square ) )
		{
			$response["good"] = false;
			$response["error"] = "This is not a player controlled piece.";
		}
		echo( json_encode( $response ) );
		break;
	default:
		break;
}
?>