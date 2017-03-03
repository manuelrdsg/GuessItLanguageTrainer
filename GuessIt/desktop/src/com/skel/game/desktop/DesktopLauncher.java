package com.skel.game.desktop;

import com.badlogic.gdx.backends.lwjgl.LwjglApplication;
import com.badlogic.gdx.backends.lwjgl.LwjglApplicationConfiguration;
import com.skel.game.MainGame;
import com.skel.util.HintSpeech;

public class DesktopLauncher {
	public static void main (String[] arg) {
		LwjglApplicationConfiguration config = new LwjglApplicationConfiguration();
		config.title = "GuessIt: Language Trainer";
		config.height = 800;
		config.width = 480;
		config.resizable = false;
		new LwjglApplication(new MainGame(new HintSpeech() {
			@Override
			public void Speech(String hint) {

			}
		}), config);
	}
}
