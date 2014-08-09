## ./config.rb
unless self.build?

  source_dir = File.join( Dir.pwd, 'source' )
  build_dir = File.join( Dir.pwd, 'build' )

  require 'rack'
  require 'rack-legacy'
  require 'rack-rewrite'

  use Rack::Rewrite do
    rewrite %r{(.*/$)}, lambda {|match, rack_env|

      ## if the file exists in source, serve it
      if File.exists?( File.join( source_dir, rack_env['PATH_INFO'], 'index.php' ) )
        return File.join( 'source', rack_env['PATH_INFO'] + 'index.php' )

      ## else if it only exists in build, build it
      elsif File.exists?( File.join( build_dir, rack_env['PATH_INFO'], 'index.php' ) )

        ## remove the leading '/' from name
        file = File.join( rack_env['PATH_INFO'], 'index.php' )
        file[0] = ""

        ## build the requested file
        puts "building: #{File.join( 'build', rack_env['PATH_INFO'], 'index.php' )}"
        %x[ middleman build -g #{file} ]

        ## pass the path on
        return File.join( 'build', rack_env['PATH_INFO'], 'index.php' )

      ## else it's an html file, so pass that on
      else
        return rack_env['PATH_INFO']
      end
    }

  end

  use Rack::Legacy::Php, Dir.pwd

end
